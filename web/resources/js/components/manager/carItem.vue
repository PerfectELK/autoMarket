<template>
    <div class="col-md-3 car__item">
        <div class="card mb-4 shadow-sm">
            <a href="javascript:void(0)" class="w-100" v-on:click="this.getModal" data-toggle="modal" data-target="#carModal">
            <img v-bind:src="description.img" alt="" class="car__item-img w-100">
            </a>
            <div class="card-body w-100">
                <p class="card-text">Активно : <b>{{description.active}}</b></p>
                <p class="card-text">Модель:  <b>{{description.title}}</b></p>
                <p class="card-text">Тип :  <b>{{this.type[description.type]}}</b></p>
                <p class="card-text">Топливо : {{description.fuel }}</p>
                <p class="card-text">{{this.loadCapOrNum[0]}} : {{this.loadCapOrNum[1]}}</p>
                <button class="btn btn-primary" v-on:click="this.showRent" data-toggle="modal" data-target="#rentModal">Аренда</button>
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
                if(this.description.loadCapacity != void(0) && this.description.loadCapacity != 0){

                    this.loadCapOrNum[0] = 'Грузоподъемность';
                    this.loadCapOrNum[1] = this.description.loadCapacity;
                }else{
                    this.loadCapOrNum[0] = 'Количество мест';
                    this.loadCapOrNum[1] = this.description.numberOfSeats;
                }
            },
            getModal:function(){
                this.$emit('modal',{description:this.description});
            },
            showRent:function(){
                this.$emit('rent',{description:this.description});
            }
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