import { extend } from 'flarum/extend';
import app from 'flarum/app';
import Composer from 'flarum/components/Composer';
import DiscussionComposer from 'flarum/components/DiscussionComposer';
import ReplyComposer from 'flarum/components/ReplyComposer';
import Button from 'flarum/components/Button';

function fadeIn(element, isInitialized, context) {
  if (isInitialized) return;

  context.retain = true;

  $(element).hide().delay(250).fadeIn();
}

function addInstructions(items, instructions) {
  if (instructions && app.composer.position === Composer.PositionEnum.NORMAL && !this.hideInstructions) {
    items.add('instructions',
      <div className="Instructions Alert" config={fadeIn}>
        <Button icon="times" className="Button Button--link Button--icon Instructions-close" onclick={() => this.hideInstructions = true}/>
        <div className="Instructions-content">
          {m.trust(instructions)}
        </div>
      </div>
    , 100);
  }
}

app.initializers.add('instructions', () => {
  extend(DiscussionComposer.prototype, 'headerItems', function(items) {
    if (app.session.user.discussionsCount() > app.forum.attribute('startInstructionsMaxDiscussions')) return;

    const instructions = app.forum.attribute('startInstructions');

    addInstructions.call(this, items, instructions);
  });

  extend(ReplyComposer.prototype, 'headerItems', function(items) {
    if (app.session.user.commentsCount() > app.forum.attribute('replyInstructionsMaxPosts')) return;

    const instructions = app.forum.attribute('replyInstructions');

    addInstructions.call(this, items, instructions);
  });
});
