<template>
    <div class="text-xs-center">
        <v-dialog
                v-model="dialog_search"
                width="300"
        >
            <v-card>
                <v-card-title
                        class="headline blue white--text"

                >
                    Buscar expediente
                </v-card-title>

                <v-card-text>
                    <v-form v-model="valid">
                        <v-text-field
                                v-model="expediente"
                                label="ingrese el numero"
                                type="number"
                                min="0"
                                required
                                :rules="expedienteRules"
                                counter="10"
                        >
                        </v-text-field>
                    </v-form>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            color="primary"
                            flat
                            @click="dialog_search = false"
                    >
                        Buscar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
    }
</script>
