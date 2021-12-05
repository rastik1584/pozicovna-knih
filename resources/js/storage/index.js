import Vue from 'vue';
import Vuex from 'vuex';
import books from "./modules/books";
import authors from "./modules/authors";

Vue.use(Vuex);
export default new Vuex.Store({
    state: {

    },
    getters: {

    },
    mutations: {

    },
    actions: {

    },
    modules: {
        books,
        authors,
    }
})
