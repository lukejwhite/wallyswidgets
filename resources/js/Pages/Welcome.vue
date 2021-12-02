<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <ApplicationLogo />
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="p-8">
                    <div class="large-font">
                        Welcome
                    </div>
                    <p>Please enter the required number of Widgets in the box below</p>
                    <input class="rounded-md shadow-lg button" type="number" v-model="numberOfWidgets" ref="input" @keyup="updateWidgets">
                    <div v-for="widget in widgets" :key="widget.id" class="widgets">
                        <div class="pack">
                            PACK SIZE: {{ widget.pack_size }}
                        </div>
                        <div class="cost">
                            &pound;{{ widget.cost }}
                        </div>
                    </div>
                    <div v-if="widgets.length > 0" class="widgets pay">
                        <div class="pack">
                            TOTAL TO PAY
                        </div>
                        <div class="cost">
                            &pound;{{ total }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .large-font{
        font-size: 3rem;
        align-items: center;
    }

    .p-8{
        padding: 2rem
    }

    .button{
        padding: 1rem;
        margin: 1rem;
        width: calc(100% - 2rem);
        border: red solid 2px;
    }

    .widgets{
        display: flex;
        justify-content: space-between;
    }

    .pay{
        font-weight: bolder;
    }
    
</style>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import ApplicationLogo from '../Jetstream/ApplicationLogo.vue'
    import Input from '../Jetstream/Input.vue'
import axios from 'axios';

    export default defineComponent({
        components: {
            Head,
            Link,
            ApplicationLogo,
            Input
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        },

        data: function(){
            return {
                widgets: {},
                numberOfWidgets: 0
            }
        },

        methods: {
            updateWidgets: function(){
                //let formData = new FormData()
                //formData.append('widgets', this.widgets)
                axios.post('/getWidgets', { widgets : this.numberOfWidgets })
                    .then(result => {
                        this.widgets = result.data;
                    } ). catch(error => {
                        console.error( error );
                    })
            }
        },

        computed: {
            total: function() {
                let total = 0;
                this.widgets.forEach(w => {
                    total += Number(w.cost)
                });
                return total.toFixed(2)
            }
        }
    })
</script>
