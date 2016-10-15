<template>
    <div class="col-md-3 col-sm-4">
        <div class="product-{{ name }}">
            <div class="form-inline">
                <div class="form-group">
                    <label>{{ name }}:</label>
                </div>
                <div class="form-group">
                    <select name="attributes[{{ name }}]"
                            v-model="selectedElement"
                            class="form-control"
                            v-on:change="changed">
                        <option v-for="option in options" value="{{ option._id }}">
                            {{ option.name }}&nbsp;{{ option.complementary_text ? '(' + option.complementary_text + ')' : '' }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
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
            changed: function() {
                this.$emit('changed', this.order, this.selectedElement);
            }
        },

        watch: {
            options: function() {
                this.selectedElement = this.options[0]._id;
            }
        }
    };

</script>