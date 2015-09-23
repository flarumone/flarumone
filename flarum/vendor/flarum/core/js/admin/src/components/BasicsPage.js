import Component from 'flarum/Component';
import FieldSet from 'flarum/components/FieldSet';
import Select from 'flarum/components/Select';
import Button from 'flarum/components/Button';
import Alert from 'flarum/components/Alert';
import saveConfig from 'flarum/utils/saveConfig';
import ItemList from 'flarum/utils/ItemList';

export default class BasicsPage extends Component {
  init() {
    this.loading = false;

    this.fields = [
      'forum_title',
      'forum_description',
      'default_locale',
      'default_route',
      'welcome_title',
      'welcome_message'
    ];
    this.values = {};

    const config = app.config;
    this.fields.forEach(key => this.values[key] = m.prop(config[key]));

    this.localeOptions = {};
    const locales = app.locales;
    for (const i in locales) {
      this.localeOptions[i] = `${locales[i]} (${i})`;
    }
  }

  view() {
    return (
      <div className="BasicsPage">
        <div className="container">
          <form onsubmit={this.onsubmit.bind(this)}>
            {FieldSet.component({
              label: '站点名称',
              children: [
                <input className="FormControl" value={this.values.forum_title()} oninput={m.withAttr('value', this.values.forum_title)}/>
              ]
            })}

            {FieldSet.component({
              label: '站点描述',
              children: [
                <div className="helpText">
                  通过几个简短的词语或句子描述您的站点，这将出现在 Meta 标记，并且在搜索引擎中出现
                </div>,
                <textarea className="FormControl" value={this.values.forum_description()} oninput={m.withAttr('value', this.values.forum_description)}/>
              ]
            })}

            {Object.keys(this.localeOptions).length > 1
              ? FieldSet.component({
                label: '默认语言',
                children: [
                  Select.component({
                    options: this.localeOptions,
                    onchange: this.values.default_locale
                  })
                ]
              })
              : ''}

            {FieldSet.component({
              label: '站点首页',
              className: 'BasicsPage-homePage',
              children: [
                <div className="helpText">
                  选择一个页面作为站点的首页。如果输入一个自定义的值，请使用基于站点根目录的相对路径
                </div>,
                this.homePageItems().toArray().map(({path, label}) =>
                  <label className="checkbox">
                    <input type="radio" name="homePage" value={path} checked={this.values.default_route() === path} onclick={m.withAttr('value', this.values.default_route)}/>
                    {label}
                  </label>
                )
              ]
            })}

            {FieldSet.component({
              label: '站点横幅',
              className: 'BasicsPage-welcomeBanner',
              children: [
                <div className="helpText">
                  配置一个横幅文本，它将显示在站点中的“所有话题”页面上
                </div>,
                <div className="BasicsPage-welcomeBanner-input">
                  <input className="FormControl" value={this.values.welcome_title()} oninput={m.withAttr('value', this.values.welcome_title)}/>
                  <textarea className="FormControl" value={this.values.welcome_message()} oninput={m.withAttr('value', this.values.welcome_message)}/>
                </div>
              ]
            })}

            {Button.component({
              type: 'submit',
              className: 'Button Button--primary',
              children: '保存更改',
              loading: this.loading,
              disabled: !this.changed()
            })}
          </form>
        </div>
      </div>
    );
  }

  changed() {
    return this.fields.some(key => this.values[key]() !== app.config[key]);
  }

  /**
   * Build a list of options for the default homepage. Each option must be an
   * object with `path` and `label` properties.
   *
   * @return {ItemList}
   * @public
   */
  homePageItems() {
    const items = new ItemList();

    items.add('allDiscussions', {
      path: '/all',
      label: '所有话题'
    });

    return items;
  }

  onsubmit(e) {
    e.preventDefault();

    if (this.loading) return;

    this.loading = true;
    app.alerts.dismiss(this.successAlert);

    const config = {};

    this.fields.forEach(key => config[key] = this.values[key]());

    saveConfig(config)
      .then(() => {
        app.alerts.show(this.successAlert = new Alert({type: 'success', children: '你的更改已保存'}));
      })
      .finally(() => {
        this.loading = false;
        m.redraw();
      });
  }
}
