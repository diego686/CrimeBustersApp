import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';

import Hello from './components/Hello';
import Navbar from './components/Navbar';
import Home from './components/Home';
import Register from './components/login/Register';
import Login from './components/login/Login';
import EventSupervisorView from './components/EventSupervisorView';
import CreateTest from './components/CreateTest';


import {BASE_URL} from './global.js';

export const EventBus = new Vue();


Vue.use(VueAxios, axios);
Vue.use(VueRouter);

const router = new VueRouter({
	routes: [
	{ 
		path: '/', component: Home
	},
	{
		path: '/register', component: Register
	},
	{
		path: '/login', component: Login
	},
	{
		path: '/create-test', component: CreateTest
	},
	{
		path: '/hello', component: Hello
	}

	],
	mode: 'history'
});


new Vue({
	el: '#app',

	router,

	components: {
		// Hello,
		Navbar,
		// EventSupervisorView
	}
}
);