import { extend, override } from 'flarum/extend';
import app from 'flarum/app';
import TextEditor from 'flarum/components/TextEditor';
import Button from 'flarum/components/Button';

app.initializers.add('imageattachments', () => {
  addCheckBeforeSubmit();
  // addUploadUI();
  addDragHook();
});

function addCheckBeforeSubmit () {
  override(TextEditor.prototype, 'onsubmit', function(original) {
      // TODO: check if all attachment is uploaded
      if(this.$('textarea').val().match(/!IMG_\d+!/)){
        if(!confirm(app.trans('imageattachments.post_anyway'))) {
          return;
        }
      }
      original();
  });
}

function addUploadUI () {
  extend(TextEditor.prototype, 'controlItems', items => {
    items.add('attachments-progress',
      (
        <div id="image-attachments-upload-progress"></div>
      )
    );
  });
}

function addDragHook () {
  extend(TextEditor.prototype, 'configTextarea', function (_0, element, isInitialized) {
    if (isInitialized) {
      return;
    }
    var editor = this;
    $(element).on('drop', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var files = e.originalEvent.dataTransfer.files;
      uploadImage(files, editor);
    });
    $(element).on('paste', function (e) {
      var items = e.originalEvent.clipboardData.items;
      if (items.length < 1) {
        return;
      }
      uploadImage(items, editor);
    });
  });
}

function uploadImage (files, editor) {
  var data = new FormData();
  var count = editor.props.imageAttachmentsCount || 0;
  editor.images = editor.images || [];
  var j = 0;
  Array.prototype.forEach.call(files, function (i) {
    if (i.getAsFile) {
      i = i.getAsFile();
    }
    if (!(i && i.type && i.type.match(/^image\//))) {
      return;
    }
    editor.images[count] = {
      filename: i.name || 'PastedImage'
    };
    data.append("images[" + count + "]", i);
    editor.insertAtCursor("!IMG_" + count + "!");
    count++;
    j++;
  });
  if (j < 1) {
    return;
  }
  editor.props.imageAttachmentsCount = count;
  app.request({
    url: app.forum.attribute('apiUrl') + '/s12g/image_attachments',
    method: 'POST',
    data: data,
    processData: false,
    serialize: raw => raw
  }).then(function(data) {
    var value = editor.$('textarea').val();
    for (var id in data) {
      var url = data[id];
      var index = id.slice(4);
      var regExp = new RegExp('!IMG_' + index + '!');
      value = value.replace(regExp, '![' + 
        editor.images[index].filename + 
        '](' + url + ')');
    }
    editor.setValue(value);
  });
}