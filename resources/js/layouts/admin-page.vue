<template>
    <v-app>
        <div id="wrapper" class="page-body">
            <div class="main-page-body main-page-admin">
                <Nav></Nav>
                <router-view></router-view>
            </div>
        </div>
    </v-app>
</template>
<script>
import Nav from "../components/Nav";

export default {
    name: 'AdminLayout',
    components: {
        Nav,
    },
    data() {
        return {
            // message: '',
        }
    },

}
</script>

