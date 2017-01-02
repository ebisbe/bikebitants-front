<template>
    <div class="form-group product-size">
        <label>{{ name }}:</label>
        <select :name="name"
                v-model="selectedElement"
                class="form-control"
                @change="changed">
            <option v-for="option in options" :value="option._id">
                {{ option.name }}&nbsp;{{ option.complementary_text ? '(' + option.complementary_text + ')' : ''
                }}
            </option>
        </select>
    </div>
</template>

<script>

    export default {

        props: ['options', 'name', 'order'],

        data() {
            return {
                'selectedElement': ''
            }
        },

        created: function () {
            this.selectedElement = this.options[0]._id;
        },

        methods: {
            changed: function () {
                this.$emit('changed', this.order, this.selectedElement);
            }
        },

        updated: function () {
            this.changed();
        }
    };

</script>