<template>
    <div class="col-md-3 car__item">
        <div class="card mb-4 shadow-sm">

            <img v-bind:src="description.item.img" alt="" class="car__item-img w-100">

            <div class="card-body w-100">
                <p class="card-text">Модель:  <b>{{description.item.title}}</b></p>
                <p class="card-text">Тип :  <b>{{this.type[description.item.type]}}</b></p>
                <p class="card-text">Топливо : {{description.item.fuel }}</p>
                <p class="card-text">Цена : {{description.item.price }}</p>
                <p class="card-text">{{this.loadCapOrNum[0]}} : {{this.loadCapOrNum[1]}}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props: ['description'],
        data:function(){
            return{
                loadCapOrNum:[],
                type:['Легковой','Грузовой']
            }
        },
        methods:{
            loadCapOrnumberOfSeats:function(){
                if(this.description.item.load_capacity != void(0) && this.description.item.load_capacity != 0){

                    this.loadCapOrNum[0] = 'Грузоподъемность';
                    this.loadCapOrNum[1] = this.description.item.load_capacity;
                }else{
                    this.loadCapOrNum[0] = 'Количество мест';
                    this.loadCapOrNum[1] = this.description.item.number_of_seats;
                }
            },
        },
        created(){
            this.loadCapOrnumberOfSeats();
        },

    }
</script>

<style>
    .car__item{
        /*flex:none!important;*/
        max-width: none;
    }
    .card-body{
        flex-direction: column;
        align-items: baseline;
    }
    .car__item-img{
        max-width: 300px;
    }
</style>