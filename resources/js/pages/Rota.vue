<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-4 order-lg-1" v-if="rolesenabled">
                <roles :date="date"></roles>
            </div>

            <div class="col-lg-4 order-lg-2" v-if="rolesenabled">
                <date-picker
                    v-model="date"
                    color="#fec107"
                ></date-picker>
            </div>

            <div class="col-lg-4 order-lg-3">
                <lunches
                    :lunchslots="lunchslots"
                    :loggedin="loggedin"
                    :initiallunch="initiallunch"
                    :available="available"
                    :appdel="appdel"
                ></lunches>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        lunchslots: {
            default: false,
            type: Array
        },
        loggedin: {
            default: false,
            type: Boolean
        },
        rolesenabled: {
            type: Boolean,
            default: false
        },
        initiallunch: {
            type: Number
        },
        appdel: {
            type: Boolean,
            default: false
        },
        available: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            date: new Date()
        };
    },
    mounted() {},
    methods: {
    }
};
</script>
