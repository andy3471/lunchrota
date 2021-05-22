<template>
    <b-navbar type="light" variant="light">
        <b-navbar-nav>
            <b-nav-item :href="$route('home')">Rota</b-nav-item>
            <b-nav-item :href="$route('about')">About</b-nav-item>

            <!-- Navbar dropdowns -->
<!--            <b-nav-item-dropdown text="Lang" right>-->
<!--                <b-dropdown-item href="#">EN</b-dropdown-item>-->
<!--                <b-dropdown-item href="#">ES</b-dropdown-item>-->
<!--                <b-dropdown-item href="#">RU</b-dropdown-item>-->
<!--                <b-dropdown-item href="#">FA</b-dropdown-item>-->
<!--            </b-nav-item-dropdown>-->

<!--            <b-nav-item-dropdown text="User" right>-->
<!--                <b-dropdown-item href="#">Account</b-dropdown-item>-->
<!--                <b-dropdown-item href="#">Settings</b-dropdown-item>-->
<!--            </b-nav-item-dropdown>-->
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto">
            <b-nav-item href="#">Login</b-nav-item>
<!--                TODO If site configured that way only-->
            <b-nav-item href="#">Register</b-nav-item>
        </b-navbar-nav>
    </b-navbar>
</template>
