<template>
    <li class="dropdown navbar-search hidden-xs">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i></a>
        <ais-index
                app-id="GBZYBNNHVF"
                api-key="a75894a515de11face2f21b34e1bcead"
                index-name="products"
                :auto-search="false"
                class="dropdown-menu"
        >
            <ul class="dropdown-menu search-list">
                <li>
                    <form @submit.prevent="">
                        <div class="input-group input-group-lg">
                            <ais-input placeholder="Buscar productos..."
                                       autofocus
                                       :class-names="{'ais-input': 'form-control'}"></ais-input>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">Search</button>
                            </span>
                        </div>
                        <ais-powered-by style="text-align: right;"></ais-powered-by>
                        <div class="row" style="margin-left: 0px">
                            <ais-stats class="col-xs-6">
                                <template slot-scope="{ totalResults, processingTime, query }">
                                    {{ totalResults }} resultado/s para : <b>{{ query }}</b>
                                </template>
                            </ais-stats>
                            <div class="col-xs-6">
                                <ais-pagination
                                        :padding="2"
                                        :class-names="{
                                'ais-pagination': 'pagination pagination-sm',
                                'ais-pagination__item--active': 'active'
                                }">
                                </ais-pagination>
                            </div>
                        </div>
                    </form>
                </li>
                <ais-results :results-per-page="4">
                    <template slot-scope="{ result }">
                        <li>
                            <div class="row row-no-padding">
                                <div class="col-xs-2">
                                    <img :src="result.image" width="100" style="padding: 15px;">
                                </div>
                                <div class="col-xs-10">
                                    <h2>
                                        <a :href="result.url">{{ result.name}}</a>
                                    </h2>
                                    <p>{{ result.meta_description }}</p>
                                </div>
                            </div>
                        </li>
                    </template>
                </ais-results>
            </ul>
            <ais-no-results>
                <template slot-scope="props">
                    <div class="row" v-show="props.query.length">
                        <div class="col-xs-12" style="text-align: center;">
                            <h3>No se han encontrado productos para la busqueda <i>{{ props.query }}</i>.</h3>
                        </div>
                    </div>
                </template>
            </ais-no-results>
        </ais-index>
    </li>
</template>
<script>
    export default {
        name: 'Search',
        data() {
            return {
                result: {}
            }
        }
    }
</script>
<style>
    .open .search-list {
        display: block;
        position: relative;
    }
</style>
