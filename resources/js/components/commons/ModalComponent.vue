<template>
    <transition name="modal" appear>
        <div class="modal modal-overlay" v-if="show" @click.self="$emit('close')">
            <div class="modal-window">
                <div class="modal-content">
                    <transition name="fade">
                    <button type="button" class="btn btn-lg btn-secondary" v-show="show_button" @click="$emit('close')">閉じる</button>
                    </transition>
                    <img :src="image_url" style="object-fit:contain;height:100%;">
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        show: {
            defalut: false
        },
        size: {
            default: ''
        },
        hideHeader: {
            default: false
        },
        hideFooter: {
            default: false
        },
        width: {
            defalut: '600px'
        }
    },
    data () {
        return {
            show_button: false,
        }
    },
    watch: {
        show: function (val) {
            if (val) {
                this.show_button = false
                const _this = this
                setTimeout(function () {
                    _this.show_button =true
                }, 3000)
            } else {
                
            }
        },
    },
    computed: {
        image_url: function () {
            return process.env.MIX_API_BASE_URL ? process.env.MIX_API_BASE_URL+'/storage/images/image02.png' : '/storage/images/image02.png'
        }
    },
    methods: {

    }
}
</script>

<style lang="scss" scoped>
.modal {
    &.modal-overlay {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        z-index: 30;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    &-window {
        width: 95vw;
        height: 95vh;
        background: #fff;
        border-radius: 4px;
        overflow: hidden;
    }

    &-header {
        background: #ccc;
        // padding: 10px;
        // text-align: right;
    }

    &-content {
        border-top-right-radius: 0;
        border-top-left-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        height: 100%;
        position: relative;
        // padding: 10px 20px;
    }
    &-content button {
        position: absolute;
        top: 60%;
        left: 50%;
        -ms-transform: translate(-50%,-50%);
        -webkit-transform: translate(-50%,-50%);
        transform: translate(-50%,-50%);
    }

    &-footer {
        // background: #ccc;
        padding: 10px;
        text-align: right;
    }
}

// オーバーレイのトランジション
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.4s;

    // オーバーレイに包含されているモーダルウィンドウのトランジション
    .modal-window {
        transition: opacity 0.4s, transform 0.4s;
    }
}

// ディレイを付けるとモーダルウィンドウが消えた後にオーバーレイが消える
.modal-leave-active {
    transition: opacity 0.6s ease 0.4s;
}

.modal-enter, .modal-leave-to {
    opacity: 0;

    .modal-window {
        opacity: 0;
        // transform: translateY(-20px);
    }
}
</style>