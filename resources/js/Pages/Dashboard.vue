<script>
    import { defineComponent, ref, toRefs, computed, defineAsyncComponent  } from "vue";
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        name: "Dashboard",
        components: {
            Head,
            Link,
        },
        setup(props, { emit, attrs }) {}
    });
</script>

<template>
    <Head title="Dashboard" />
    <Link :href="route('goods')">Goods</Link>
    <br />
    <Link :href="route('categories')">Categories</Link>
</template>
