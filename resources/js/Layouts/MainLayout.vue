<template>
    <div>
        <nav-bar />
        <b-jumbotron bg-variant="primary" text-variant="white" border-variant="dark">
            <template #lead>
                <h1>
                    {{ $page.props.config.name }}
                </h1>
            </template>
        </b-jumbotron>
        <main class="py-4">
            <slot></slot>
        </main>
    </div>
</template>
<script>
import NavBar from '../Components/Layout/NavBar'

export default {
    components: { NavBar }
}
</script>
