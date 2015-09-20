import app from 'flarum/app';

import SMTPSettingsModal from 'smtp/components/SMTPSettingsModal';

app.initializers.add('smtp', () => {
  app.extensionSettings.smtp = () => app.modal.show(new SMTPSettingsModal());
});
