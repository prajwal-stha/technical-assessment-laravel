<template>
    <v-app>
        <div id="wrapper" class="page-body">
            <div class="main-page-body">
                <Nav></Nav>
                <router-view></router-view>
            </div>
        </div>
    </v-app>
</template>
<script>
import Nav from "../components/Nav";

export default {
    name: 'FrontLayout',
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

