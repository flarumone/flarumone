import Component from 'flarum/Component';
import PermissionDropdown from 'flarum/components/PermissionDropdown';
import ConfigDropdown from 'flarum/components/ConfigDropdown';
import Button from 'flarum/components/Button';
import ItemList from 'flarum/utils/ItemList';
import icon from 'flarum/helpers/icon';

export default class PermissionGrid extends Component {
  constructor(...args) {
    super(...args);

    this.permissions = this.permissionItems().toArray();
  }

  view() {
    const scopes = this.scopeItems().toArray();

    const permissionCells = permission => {
      return scopes.map(scope => (
        <td>
          {scope.render(permission)}
        </td>
      ));
    };

    return (
      <table className="PermissionGrid">
        <thead>
          <tr>
            <td></td>
            {scopes.map(scope => (
              <th>
                {scope.label}{' '}
                {scope.onremove ? Button.component({icon: 'times', className: 'Button Button--text PermissionGrid-removeScope', onclick: scope.onremove}) : ''}
              </th>
            ))}
            <th>{this.scopeControlItems().toArray()}</th>
          </tr>
        </thead>
        {this.permissions.map(section => (
          <tbody>
            <tr className="PermissionGrid-section">
              <th>{section.label}</th>
              {permissionCells(section)}
              <td/>
            </tr>
            {section.children.map(child => (
              <tr className="PermissionGrid-child">
                <th>{child.icon ? icon(child.icon) : ''}{child.label}</th>
                {permissionCells(child)}
                <td/>
              </tr>
            ))}
          </tbody>
        ))}
      </table>
    );
  }

  permissionItems() {
    const items = new ItemList();

    items.add('view', {
      label: '浏览',
      children: this.viewItems().toArray()
    }, 100);

    items.add('start', {
      label: '创建',
      children: this.startItems().toArray()
    }, 90);

    items.add('reply', {
      label: '回复',
      children: this.replyItems().toArray()
    }, 80);

    items.add('moderate', {
      label: '管理',
      children: this.moderateItems().toArray()
    }, 70);

    return items;
  }

  viewItems() {
    const items = new ItemList();

    items.add('view', {
      icon: 'eye',
      label: '浏览话题',
      permission: 'forum.view',
      allowGuest: true
    }, 100);

    items.add('signUp', {
      icon: 'user-plus',
      label: '注册账号',
      setting: () => ConfigDropdown.component({
        key: 'allow_sign_up',
        options: [
          {value: '1', label: '开启'},
          {value: '0', label: '关闭'}
        ]
      })
    }, 90);

    return items;
  }

  startItems() {
    const items = new ItemList();

    items.add('start', {
      icon: 'edit',
      label: '创建话题',
      permission: 'forum.startDiscussion'
    }, 100);

    items.add('allowRenaming', {
      icon: 'i-cursor',
      label: '修改标题',
      setting: () => {
        const minutes = parseInt(app.config.allow_renaming, 10);

        return ConfigDropdown.component({
          defaultLabel: minutes ? `For ${minutes} minutes` : 'Indefinitely',
          key: 'allow_renaming',
          options: [
            {value: '-1', label: '无限期'},
            {value: '10', label: '发布 10 分钟内'},
            {value: 'reply', label: '直到被回复'}
          ]
        });
      }
    }, 90);

    return items;
  }

  replyItems() {
    const items = new ItemList();

    items.add('reply', {
      icon: 'reply',
      label: '回复话题',
      permission: 'discussion.reply'
    }, 100);

    items.add('allowPostEditing', {
      icon: 'pencil',
      label: '修改回复',
      setting: () => {
        const minutes = parseInt(app.config.allow_post_editing, 10);

        return ConfigDropdown.component({
          defaultLabel: minutes ? `For ${minutes} minutes` : 'Indefinitely',
          key: 'allow_post_editing',
          options: [
            {value: '-1', label: '无限期'},
            {value: '10', label: '发表 10 分钟内'},
            {value: 'reply', label: '直到下一条回复'}
          ]
        });
      }
    }, 90);

    return items;
  }

  moderateItems() {
    const items = new ItemList();

    items.add('renameDiscussions', {
      icon: 'i-cursor',
      label: '重命名话题',
      permission: 'discussion.rename'
    }, 100);

    items.add('hideDiscussions', {
      icon: 'trash-o',
      label: '屏蔽话题',
      permission: 'discussion.hide'
    }, 90);

    items.add('deleteDiscussions', {
      icon: 'times',
      label: '删除话题',
      permission: 'discussion.delete'
    }, 80);

    items.add('editPosts', {
      icon: 'pencil',
      label: '修改和删除回复',
      permission: 'discussion.editPosts'
    }, 70);

    items.add('deletePosts', {
      icon: 'times',
      label: '删除回复',
      permission: 'discussion.deletePosts'
    }, 60);

    return items;
  }

  scopeItems() {
    const items = new ItemList();

    items.add('global', {
      label: '全局',
      render: item => {
        if (item.setting) {
          return item.setting();
        } else if (item.permission) {
          return PermissionDropdown.component({
            permission: item.permission,
            allowGuest: item.allowGuest
          });
        }

        return '';
      }
    }, 100);

    return items;
  }

  scopeControlItems() {
    return new ItemList();
  }
}
