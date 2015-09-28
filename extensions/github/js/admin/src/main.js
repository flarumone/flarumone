import app from 'flarum/app';

import GithubSettingsModal from 'github/components/GithubSettingsModal';

app.initializers.add('github', () => {
  app.extensionSettings.github = () => app.modal.show(new GithubSettingsModal());
});
