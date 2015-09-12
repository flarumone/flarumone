import { extend } from 'flarum/extend';
import app from 'flarum/app';

app.initializers.add('noslug', () => {
  app.route.discussion = (discussion, near) => {
    return app.route(near && near !== 1 ? 'discussion.near' : 'discussion', {
      id: discussion.id(),
      near: near && near !== 1 ? near : undefined
    });
  };
});
