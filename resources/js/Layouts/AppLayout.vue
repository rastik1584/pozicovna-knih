<template>
    <div>
        <Head :title="title" />
        <div class="col-12 col-md-3 left">
            <h1><Link :href=" route('homepage') ">Požičovňa kníh</Link></h1>
            <left-menu />
        </div>
        <div class="col-12 col-md-9 right">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import LeftMenu from "@/Pages/Components/LeftMenu";
    import 'bootstrap/scss/bootstrap.scss'
    import { library } from "@fortawesome/fontawesome-svg-core";
    import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
    import { fas } from '@fortawesome/free-solid-svg-icons'
    library.add(fas);
    import { fab } from '@fortawesome/free-brands-svg-icons';
    library.add(fab);
    import { far } from '@fortawesome/free-regular-svg-icons';
    library.add(far);
    import { dom } from "@fortawesome/fontawesome-svg-core";
    dom.watch();

    export default defineComponent({

        props: {
            title: String,
        },

        components: {
            Head,
            Link,
            LeftMenu,
            "font-awesome-icon": FontAwesomeIcon
        },
    })
</script>

<style lang="scss">
body {
    margin: 0;
    padding: 0;
    .left {
        position: fixed;
        background: #333;
        height: 100vh;
        color: #fff;
        display: inline-flex;
        flex-direction: column;
        h1>a {
            display: flex;
            justify-content: center;
            color: #fff;
            text-decoration: none;
        }
    }
    .right {
        background: #444;
        height: 100%;
        color: #fff;
        display: inline-flex;
        flex-direction: column;
        margin-left: 25%;
        min-height: 100vh;
    }
    .inverse {
        color: #fff;
    }
    .actions button {
        float: left;
        &:nth-child(1) {
            margin-right: 5px;
        }
    }
    .flash-message {
        background: #eaeaea;
        color: #000;
        padding: 10px 15px;
        width: 80%;
        margin: 0 auto;
        &.success {
            border: 5px solid lightgreen;

        }
        &.error {
            border: 5px solid red;

        }
    }
    .create-button {
        &>a {
            float: right;
            margin-right: 25px;
        }
        label {
            padding: 0 15px;
        }
        input#filter {
            color: #000;
        }
        button {
            margin-left: 15px;
        }
    }
}
</style>
