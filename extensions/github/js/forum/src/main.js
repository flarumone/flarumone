import { extend } from 'flarum/extend';
import app from 'flarum/app';
import LogInButtons from 'flarum/components/LogInButtons';
import LogInButton from 'flarum/components/LogInButton';

app.initializers.add('github', () => {
  extend(LogInButtons.prototype, 'items', function(items) {
    items.add('github',
      <LogInButton
        className="Button LogInButton--github"
        icon="github"
        path="/login/github">
        Log in with GitHub
      </LogInButton>
    );
  });
});
