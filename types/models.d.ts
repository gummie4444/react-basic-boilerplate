/** TodoMVC model definitions **/

declare interface TodoItemData {
  id?: TodoItemId;
  text?: string;
  completed?: boolean;
}

declare type TodoItemId = number;

declare type TodoFilterType = 'SHOW_ALL' | 'SHOW_ACTIVE' | 'SHOW_COMPLETED';

declare type TodoStoreState = TodoItemData[];

//USER
declare type UserItemId = number;
declare type UserPassword = string;

declare interface UserItemData {
  id?: UserItemId;
  lastLogin?: string;
  userName?: string;
  token?: string;
}

declare type UserStoreState = UserItemData;
