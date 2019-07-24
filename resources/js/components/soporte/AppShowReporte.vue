<template>
    <v-hover>
        <v-card
            slot-scope="{ hover }"
            class="mx-auto"
            color="grey lighten-4"
            max-width="600"
        >
            <v-img
                :aspect-ratio="16/9"
                src="/img/home.jpg"
            >
                <v-expand-transition>
                    <div
                        v-if="hover"
                        class="d-flex transition-fast-in-fast-out green darken-2 v-card--reveal display-3 white--text"
                        style="height: 100%;"
                    >
                      Sistema Expeco
                    </div>
                </v-expand-transition>
            </v-img>
            <v-card-text
                class="pt-4"
                style="position: relative;"
            >
                <v-btn
                    absolute
                    color="orange"
                    class="white--text"
                    fab
                    large
                    right
                    top
                >
                    <v-icon>add</v-icon>
                </v-btn>
                <div class="font-weight-light grey--text title mb-2">Aún por definir</div>
                <h3 class="display-1 font-weight-light orange--text mb-2">Motivación del día.</h3>
                <div class="font-weight-light title mb-2">
                    Cúando logres tus objetivos, sabras el motivo de tu<br>
                    ESFUERZO.
                </div>
            </v-card-text>
        </v-card>
    </v-hover>
</template>
<style>
    .v-card--reveal {
        align-items: center;
        bottom: 0;
        justify-content: center;
        opacity: .5;
        position: absolute;
        width: 100%;
    }
</style>
