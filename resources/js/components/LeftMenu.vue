<template>
    <ul class="nav flex-column">
        <li class="nav-item">
            <router-link :to="{path: '/autori'}" >Autori</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{path: '/knihy'}" >Knihy</router-link>
        </li>
    </ul>
</template>

<script>
export default {
    name: "LeftMenu"
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
            &.router-link-active {
                color: lightgreen;
            }
        }
    }
}
</style>
