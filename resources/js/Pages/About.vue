<template>
    <main-layout>
        <b-container>
            <table class="table table-bordered">
                <tbody>
                <th colspan="2">
                    <div class="text-center">
                        About
                    </div>
                </th>
                <tr>
                    <td style="width:25%">
                        Created By:
                    </td>
                    <td>
                        Complete rewrite by <a href="https://andyh.app">Andrew Hargrave</a>, based on an original project by <a href="https://curtisreet.co.uk">Curtis Reet</a>.
                    </td>
                </tr>
                <tr>
                    <td>
                        Created Using:
                    </td>
                    <td>
                        Laravel 8, Inirtia, Vue JS and Bootstrap
                    </td>
                </tr>
                <tr>
                    <td>
                        Local Admins:
                    </td>
                    <td>
                        <a v-for="(admin, index) in admins" :href="admin.meme" class="meme">
                            {{ nameWithComma(index) }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Version:</td>
                    <td>{{ $page.props.config.version }}</td>
                </tr>
                <tr>
                    <td>GitHub:</td>
                    <td><a href="https://github.com/andy3471/rota">Github</a></td>
                </tr>
                <tr>
                    <td>Report an issue:</td>
                    <td><a href="https://github.com/andy3471/lunchrota/issues/new/choose">Report Issue</a></td>
                </tr>
                </tbody>
            </table>
        </b-container>
    </main-layout>
</template>
<script>
import MainLayout from '../Layouts/MainLayout'

export default {
    components: { MainLayout },
    props: {
        admins: {
            required: true,
            type: Array
        }
    },
    methods:{
        nameWithComma(index){
            if(index!==this.admins.length-1){
                return `${this.admins[index].name},`;
            }else{
                return this.admins[index].name;
            }
        }
    }
}
</script>
