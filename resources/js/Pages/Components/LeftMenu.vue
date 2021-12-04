<template>
    <ul class="nav flex-column">
        <li class="nav-item">
            <Link :href="route('autori.index')" class="nav-link" :class="{'active': $page.component === 'Authors'}" >Autori</Link>
        </li>
        <li class="nav-item">
            <Link :href="route('knihy.index')" class="nav-link" :class="{'active': $page.component === 'Books'}">Knihy</Link>
        </li>
    </ul>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        name: 'LeftMenu',
        components: {
            Link,
        }
    }
</script>

<style lang="scss" scoped>
    ul.nav {
        li {
            border-bottom: 1px solid #fff;
            a {
                color: #fff;
                transition: 0.5s;
                position: relative;
                &:hover {
                    padding-left: 25px;
                    transition: .5s;
                }
                &.active {
                    &::after {
                        content: '<-';
                        position: absolute;
                        top: 50%;
                        left: 20%;
                        transform: translate(0,-50%);
                    }
                }
            }
        }
    }
</style>
