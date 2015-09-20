import SettingsModal from 'flarum/components/SettingsModal';

export default class InstructionsSettingsModal extends SettingsModal {
  className() {
    return 'InstructionsSettingsModal';
  }

  title() {
    return 'Instructions Settings';
  }

  form() {
    return [
      <div className="Form-group">
        <label>Start a Discussion Instructions</label>
        <textarea className="FormControl" bidi={this.setting('instructions.start_instructions')}/>

        Hide for users with more than
        <input className="FormControl" type="number" min="0" bidi={this.setting('instructions.start_instructions_max_discussions')}/>
        discussions
      </div>,

      <div className="Form-group">
        <label>Reply Instructions</label>
        <textarea className="FormControl" bidi={this.setting('instructions.reply_instructions')}/>

        Hide for users with more than
        <input className="FormControl" type="number" min="0" bidi={this.setting('instructions.reply_instructions_max_posts')}/>
        posts
      </div>
    ];
  }
}
