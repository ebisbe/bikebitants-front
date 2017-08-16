<template>
    <ul class="list-unstyled" id="categories2">
        <li class="panel" v-for="category in categories">
            <span class="fa"
                :class="{ selected: selCat != category._id }"
                  @click="selectedCat(category._id)"
            ></span>
            <a :href="'/' + category.slug"
               :class="{ collapsed: selCat != category._id }">{{ category.name }}
                <span>[{{ category.products_count }}]</span>
            </a>
            <ul class="list-unstyled"
                :class="{ collapse: selCat != category._id }"
            >
                <li
                        v-for="subcategory in category.children"
                    :class="{ active: subcat == subcategory._id }"
                >
                    <a :href="'/' + category.slug + '/' + subcategory.slug">{{ subcategory.name }}</a>
                </li>
            </ul>
        </li>
    </ul>
</template>
<script>
    export default {
        name: 'categories',
        props: ['categories', 'cat', 'subcat'],
        data() {
            return {
                'selCat': ''
            }
        },

        created () {
           this.selCat = this.cat;
        },

        methods: {
            selectedCat: function (selectedCat) {
                this.selCat = selectedCat;
            }
        }
    }
</script>