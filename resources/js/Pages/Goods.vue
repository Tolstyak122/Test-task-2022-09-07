<script>
    import { defineComponent, ref, computed, onMounted } from "vue";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        name: "Goods",
        components: {
            Head,
            Link,
        },
        setup(props, { emit, attrs }) {

            const goods = ref([]);
            const loading = ref(true);
            const filters = ref({
                good_name: '',
                cat_name: '',
                cat_id: '',
                price: {min: 0, max: 0},
                published: true,
                trash: false,
            });

            const loader = () => {
                loading.value = true;
                axios
                    .get(route('api.goods', filters.value))
                    .then(res => {
                        goods.value = res.data;
                        loading.value = false;
                    })
            }

            const kill = good_id => {
                loading.value = true;
                axios
                    .delete(route('api.goods.delete', {good: good_id}))
                    .then(res => {
                        Inertia.get(route('goods'));
                    })
            }

            const onSuccessListener = Inertia.on('success', ev => {
                if(ev.detail.page.component == 'Goods') {
                    loader();
                }
            })

            onMounted(() => {
                loader();
            })

            return { goods, loading, kill, filters, loader }
        }
    });
</script>

<template>
    <Head title="Goods" />
    <h3 v-show="loading">Loading data...</h3>
    <template v-if="!loading">
        <p>
            <Link :href="route('/')">Back to dashboard</Link>
            <br/>
            <Link :href="route('goods.create')">Add new good</Link>
        </p>
        <p>
            <label for="good_title">
                Good title:
                <input id="good_title" type="text" v-model="filters.good_name" />
            </label>
            <label for="good_price_min" style="margin-left: 10px;">
                Min price:
                <input id="good_price_min" type="text" v-model="filters.price.min" />
            </label>
            <label for="good_price_max" style="margin-left: 10px;">
                Max price:
                <input id="good_price_max" type="text" v-model="filters.price.max" />
            </label><br />
            <label for="cat_title">
                Category title:
                <input id="cat_title" type="text" v-model="filters.cat_name" />
            </label>
            <label for="cat_id" style="margin-left: 10px;">
                Category id:
                <input id="cat_id" type="text" v-model="filters.cat_id" />
            </label><br />
            <label for="good_published">
                Published:
                <input id="good_published" type="checkbox" v-model="filters.published" />
            </label>
            <label for="good_trash" style="margin-left: 10px;">
                With trash:
                <input id="good_trash" type="checkbox" v-model="filters.trash" />
            </label><br />
            <button @click="loader">Filter</button>
        </p>
        <hr/>
        <ul>
            <li v-for="(good, indx) in goods" :key="good.id">
                <span>{{ good.title }}</span>
                <span style="margin-left: 10px;">
                    <Link :href="route('goods.edit', {good: good.id})">edit</Link>
                </span>
                <span style="margin-left: 10px;">
                    <button @click="kill(good.id)">Delete</button>
                </span>
            </li>
        </ul>
    </template>
</template>
