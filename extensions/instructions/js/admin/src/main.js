import app from 'flarum/app';

import InstructionsSettingsModal from 'instructions/components/InstructionsSettingsModal';

app.initializers.add('instructions', () => {
  app.extensionSettings.instructions = () => app.modal.show(new InstructionsSettingsModal());
});
