/*globals m*/

import app from 'flarum/app';
import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';
import Select from 'flarum/components/Select';
import saveConfig from 'flarum/utils/saveConfig';

app.initializers.add('imageattachments', () => {
  app.extensionSettings.imageattachments = () => app.modal.show(new ImageAttachmentsModal());
});

var drivers = '';

class ImageAttachmentsModal extends Modal {
  constructor(...args) {
    super(...args);

    this.driver = m.prop(app.config['imageattachments.driver'] || 'local');
    this.loading = m.prop(true);
    this.driverList = m.prop([]);
    this.selectDriver = m.prop('');
    this.driverConfig = m.prop('');
    if (!drivers) {
      app.request({
        url: app.forum.attribute('apiUrl') + '/s12g/image_attachments'
      })
      .then((data) => {
        drivers = data;
        loadDrivers.call(this);
      });
    } else {
      loadDrivers.call(this);
    }
    this.loadingText = m.prop('Loading Drivers');
    function loadDrivers() {
      this.loading(false);
      this.loadingText = m.prop('Save Changes');
      // build select driver
      var options = {};
      for (var driverName in drivers) {
        var driverConfig = drivers[driverName];
        var driverTitle = driverConfig.title;
        options[driverName] = driverTitle;
      }
      this.selectDriver(Select.component({
        options: options,
        value: this.driver(),
        onchange: this.onDriverChange.bind(this)
      }));
      this.onDriverChange(this.driver());
      m.redraw();
    }
  }

  className() {
    return 'Modal--small';
  }

  title() {
    return 'Image Attachments Settings';
  }
  
  onDriverChange(currentDriver) {
    this.driver(currentDriver);
    // read driver config items
    var driverConfig = drivers[currentDriver] || {};
    var configItems = driverConfig.config;
    if (configItems) {
      var ui = [];
      for (var key in configItems) {
        (function(key) {
          var cfg = configItems[key];
          var configKey = 'imageattachments.' + currentDriver + '.config';
          var currentValue = (JSON.parse(app.config[configKey] || '{}') || {})[key] || '';
          ui.push(
            <div className="Form-group">
              <label>{cfg.title}</label>
              <input type="text" value={currentValue} className="FormControl" name={key} />
              <p>{cfg.hint}</p>
            </div>
          );
        }).call(this, key);
      }
      this.driverConfig(ui);
    } else {
      // no config items
      this.driverConfig('');
    }
  }

  content() {
    return (
      <div className="Modal-body">
        <div className="Form">
          <div className="Form-group">
            <label>Storage Driver</label>
            {this.selectDriver()}
          </div>
          {this.driverConfig()}
          <div className="Form-group">
            {Button.component({
              type: 'submit',
              className: 'Button Button--primary',
              loading: this.loading(),
              children: this.loadingText()
            })}
          </div>
        </div>
      </div>
    );
  }

  onsubmit(e) {
    e.preventDefault();
    var $target = $(e.target);
    // get current Driver
    var currentDriver = this.driver();
    // get config keys
    var configToSave = {
      'imageattachments.driver': currentDriver
    };
    var configItems = drivers[currentDriver].config;
    if (configItems) {
      var configKeys = Object.keys(configItems);
      var configObj = configKeys.reduce(function(prev, key) {
        prev[key] = $target.find('[name="' + key + '"]').val();
        return prev;
      }, {});
      configToSave['imageattachments.' + currentDriver + '.config'] = JSON.stringify(configObj);
    }
    this.loading(true);
    drivers = '';
    
    saveConfig(configToSave).then(
      () => this.hide(),
      () => {
        this.loading(false);
        m.redraw();
      }
    );
  }
}
