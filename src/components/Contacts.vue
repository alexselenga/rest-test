<template>
  <v-container>
    <v-data-table
        :headers="headers"
        :items="contacts"
        :search="search"
        sort-by="name"
        class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
            flat
        >
          <v-toolbar-title>Телефонная книга</v-toolbar-title>
          <v-divider
              class="mx-4"
              inset
              vertical
          ></v-divider>
          <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Поиск"
              single-line
              hide-details
          ></v-text-field>
          <v-divider
              class="mx-4"
              inset
              vertical
          ></v-divider>
          <v-spacer></v-spacer>
          <v-dialog
              v-model="dialog"
              max-width="500px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                  color="primary"
                  dark
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
              >
                Добавить
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-form
                      ref="form"
                      v-model="valid"
                      lazy-validation
                  >
                    <v-row>
                      <v-col
                          cols="12"
                      >
                        <v-text-field
                            v-model="editedItem.name"
                            label="Имя"
                            :rules="rules.name"
                        ></v-text-field>
                      </v-col>
                      <v-col
                          cols="12"
                          sm="6"
                      >
                        <v-text-field
                            v-model="editedItem.phone"
                            label="Телефон"
                            :rules="rules.phone"
                        ></v-text-field>
                      </v-col>
                      <v-col
                          cols="12"
                          sm="6"
                      >
                        <v-text-field
                            v-model="editedItem.country_code"
                            label="Код страны"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <div class="error--text" v-if="errors.length" v-html="errors"></div>
                  </v-form>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="close"
                >
                  Отмена
                </v-btn>
                <v-btn
                    color="blue darken-1"
                    text
                    @click="save"
                    :disabled="!valid"
                >
                  Сохранить
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline">Вы действительно хотите<br/>удалить пользователя?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Отмена</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">Да</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
            small
            class="mr-2"
            @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
            small
            @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn
            color="primary"
            @click="initialize"
        >
          Обновить
        </v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>

<script>
  import axios from 'axios'

  const contactsUrl = process.env.REST_APP_URL + 'contacts'

  export default {
    name: 'Contacts',

    data: () => ({
      search: '',
      dialog: false,
      dialogDelete: false,
      errors: '',
      headers: [
        {
          text: 'Имя',
          value: 'name',
          align: 'start',
        },
        {
          text: 'Телефон',
          value: 'phone',
          align: 'start',
          sortable: false,
        },
        {
          text: 'Код страны',
          value: 'country_code',
          align: 'start',
        },
        {
          text: 'Действия',
          value: 'actions',
          sortable: false,
        },
      ],
      contacts: [],
      editedIndex: -1,
      editedItem: {
        id: null,
        name: '',
        phone: '',
        country_code: '',
      },
      defaultItem: {
        id: null,
        name: '',
        phone: '',
        country_code: '',
      },
      rules: {
        name: [
          value => !!value || 'Необходимо заполнить.',
          // value => (value && value.length >= 3) || 'Минимум 3 символа',
        ],
        phone: [
          value => !!value || 'Необходимо заполнить.',
          // value => (value && value.length >= 3) || 'Минимум 10 символов',
        ],
      },
      valid: true,
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Добавить контакт' : 'Редактирование контакта'
      },
    },

    watch: {
      dialog (val) {
        if (val) return
        this.$refs.form.resetValidation()
        this.errors = ''
        this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      async initialize () {
        const res = await axios.get(contactsUrl)
        this.contacts = res.data
      },

      editItem (item) {
        this.editedIndex = this.contacts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      async save () {
        if (!this.$refs.form.validate()) {
          return
        }
        try {
          if (this.editedIndex > -1) {
            const res = await axios.put(`${contactsUrl}/${this.editedItem.id}`, this.editedItem, {withCredentials: true})
            Object.assign(this.contacts[this.editedIndex], res.data)
          } else {
            const res = await axios.post(contactsUrl, this.editedItem, {withCredentials: true})
            console.log(res.data)
            this.contacts.push(res.data)
          }
          this.close()
        } catch (error) {
          if (error.response.status === 422) {
            this.errors = error.response.data.map(item => item.message).join('<br>')
          } else {
            this.errors = `Сетевая ошибка (${error.response.status}).`
          }
        }
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      deleteItem (item) {
        this.editedIndex = this.contacts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      async deleteItemConfirm () {
        await axios.delete(`${contactsUrl}/${this.editedItem.id}`, {withCredentials: true})
        this.contacts.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },
    },
  }
</script>
