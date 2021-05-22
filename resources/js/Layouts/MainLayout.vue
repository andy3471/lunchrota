<template>
    <div>
        <div class="container-fluid header">
            <div class="row">
                <div class="col-lg-2">
<!--                    TODO use asset -->
                    <a href="/">
                        <img src="img/logo_default.png" style="width:10rem">

                    </a>
                </div>
                <div class="col-sm-10 title">
                    <h1 class="">{{ $page.props.appName }}</h1>
                </div>
            </div>
        </div>
        <nav-bar />
        <main class="py-4">
            <b-container>
                <slot></slot>
            </b-container>
        </main>
        <bottom-bar />
    </div>
</template>
<script>
import NavBar from '../Components/Layout/NavBar'
import BottomBar from '../Components/Layout/BottomBar'

export default {
    components: { NavBar, BottomBar }
}
</script>
