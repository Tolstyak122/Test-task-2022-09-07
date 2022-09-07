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

            const good_id = ref(attrs.good_id || 0);
            const errors = ref('');
            const categories = ref([]);
            const loading = ref(true);
            const good = ref({
                title: '',
                price: 0,
                published: false,
                categories: [],
            });

            const loader = () => {
                loading.value = true;
                axios
                    .get(route('api.categories'))
                    .then(res => {
                        categories.value = res.data;
                        return (!good_id.value ? false : axios.get(route('api.good', {good: good_id.value})));
                    })
                    .then(res => {
                        if(res) {
                            good.value = res.data;
                            categories.value.forEach(item => {
                                item.published = good.value.categories.indexOf(item.id) > -1;
                            });
                        }
                        loading.value = false;
                    })
            }

            const send = () => {
                const method = good_id.value ? 'put' : 'post';
                const suffix = good_id.value ? 'update' : 'create';
                const route_data = good_id.value ? {good: good_id.value} : {};
                loading.value = true;
                errors.value = '';
                good.value.categories = categories.value.filter(item => item.published).map(item => item.id);
                axios[method](route('api.goods.' + suffix, route_data), { ...good.value })
                    .then(res => {
                        Inertia.get(route('goods.edit', {good: res.data.id}));
                        loading.value = false;
                    })
                    .catch(res => {
                        errors.value = res.response.data.message;
                        loading.value = false;
                    })
            }

            const onSuccessListener = Inertia.on('success', ev => {
                if(ev.detail.page.component == 'Good') {
                    good_id.value = ev.detail.page.props.good_id;
                    loader();
                }
            })

            onMounted(() => {
                loader();
            })

            return { good, categories, loading, send, errors }
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
            <br/>
            <Link :href="route('goods')">Back to goods list</Link>
        </p>
        <p>
            <label for="good_title">
                Title:
                <input id="good_title" type="text" v-model="good.title" />
            </label><br />
            <label for="good_price">
                Price:
                <input id="good_price" type="text" v-model="good.price" />
            </label><br />
            <label for="good_published">
                Published:
                <input id="good_published" type="checkbox" v-model="good.published" />
            </label><br />
            <button @click="send">Save</button>
        </p>
        <hr/>
        <ul>
            <li v-for="(category, indx) in categories" :key="category.id">
                <label :for="'category_' + category.id">
                    {{ category.title }}
                    <input :id="'category_' + category.id" type="checkbox" v-model="category.published" />
                </label>
            </li>
        </ul>
    </template>
</template>
