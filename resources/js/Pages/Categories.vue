<script>
    import { defineComponent, ref, computed, onMounted } from "vue";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        name: "Good",
        components: {
            Head,
            Link,
        },
        setup(props, { emit, attrs }) {

            const errors = ref('');
            const title = ref('');
            const categories = ref([]);
            const loading = ref(true);

            const loader = () => {
                loading.value = true;
                axios
                    .get(route('api.categories'))
                    .then(res => {
                        categories.value = res.data;
                        loading.value = false;
                    })
            }

            const send = () => {
                loading.value = true;
                errors.value = '';
                axios.post(route('api.categories'), { title: title.value })
                    .then(res => {
                        Inertia.get(route('categories'));
                    })
                    .catch(res => {
                        errors.value = res.response.data.message;
                        loading.value = false;
                    })
            }

            const kill = category_id => {
                loading.value = true;
                axios
                    .delete(route('api.categories.delete', {category: category_id}))
                    .then(res => {
                        Inertia.get(route('categories'));
                    })
                    .catch(res => {
                        errors.value = res.response.data.message;
                        loading.value = false;
                    })
            }

            const onSuccessListener = Inertia.on('success', ev => {
                if(ev.detail.page.component == 'Categories') {
                    loader();
                }
            })

            onMounted(() => {
                loader();
            })

            return { title, categories, loading, kill, send, errors }
        }
    });
</script>

<template>
    <Head title="Good" />
    <h3 v-show="loading">Loading data...</h3>
    <h4 v-show="errors" style="color: red;">
        {{ errors }}
    </h4>
    <template v-if="!loading">
        <p>
            <Link :href="route('/')">Back to dashboard</Link>
        </p>
        <p>
            <label for="category_title">
                Title:
                <input id="category_title" type="text" v-model="title" />
            </label><br />
            <button @click="send">Create</button>
        </p>
        <hr/>
        <ul>
            <li v-for="(category, indx) in categories" :key="category.id">
                <span>{{ category.title }} (goods: {{ category.goods_count }})</span>
                <span style="margin-left: 10px;">
                    <button @click="kill(category.id)">Delete</button>
                </span>
            </li>
        </ul>
    </template>
</template>
