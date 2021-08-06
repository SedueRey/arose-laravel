
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import ChatConversations from './components/ChatConversations';
import ChatForm from './components/ChatForm';
import ChatMessages from './components/ChatMessages';
import ConversationParticipants from './components/ConversationParticipants';
import ExampleComponent from './components/ExampleComponent';
import RubricForm from './components/rubrics/RubricForm';
import ConfigGrading from './components/gradebook/configGrading/configGrading.vue';
import StudentGrading from './components/gradebook/studentGrading/studentGrading.vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

const app = new Vue({
  el: '#app',
  components: {
    ChatConversations,
    ChatForm,
    ChatMessages,
    ConversationParticipants,
    ExampleComponent,
    RubricForm,
    ConfigGrading,
    StudentGrading,
  }
});
