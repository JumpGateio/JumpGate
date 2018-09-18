<template>
  <div class="artisan pl-2 pt-2">
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search..." v-model="search" @keyup="toggleCommands(true)">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button"
                v-text="searchButtonText + ' commands'" @click="toggleCommands()"
        ></button>
      </div>
    </div>
    <div class="command-list" v-if="showCommands">
      <div :class="commandClass(command)" v-for="command in filteredCommands" @click="setUpCommand(command)">
        <div class="name" v-text="command.name"></div>
        <div class="description text-muted" v-text="command.description"></div>
      </div>
    </div>
    <div v-if="selectedCommand != null">
      <div class="details">
        <div class="name" v-text="selectedCommand.name"></div>
        <div class="description" v-text="selectedCommand.description"></div>
      </div>
      <div class="passables" v-if="hasPassables">
        <div v-for="(argument, index) in selectedCommand.passables" :class="[argument.mode, argument.type]">
          <div class="name">
            {{ argument.mode | capitalize }}: {{ argument.display }}
            <span class="badge">{{ argument.type }}</span>
          </div>
          <div class="description text-muted" v-if="argument.description != null" v-text="argument.description"></div>
          <input type="text" v-if="argument.type != 'flag'" v-model="selectedCommand.passables[index].value"
                 class="form-control form-control-sm">
          <button type="button" class="btn btn-block btn-xs btn-outline-primary" data-toggle="button"
                  v-if="argument.type == 'flag'" :class="argument.value ? 'active' : null"
                  v-model="selectedCommand.passables[index].value" @click="toggleFlag(index)">
            Add Flag
          </button>
        </div>
      </div>
      <button class="btn btn-primary btn-sm" @click="runCommand()">Run command</button>
    </div>
    <div v-if="results != null || running == true">
      <h4 class="mt-5">Results</h4>
      <pre class="results" :class="resultClass" v-html="results"></pre>
    </div>
  </div>
</template>

<style scoped>
  ::-webkit-scrollbar {
    width:  10px;
    height: 10px;
  }

  ::-webkit-scrollbar-track {
    background: #252830;
  }

  ::-webkit-scrollbar-corner {
    background: #252830;
  }

  ::-webkit-scrollbar-thumb {
    background:    #51586a;
    border-radius: .25rem;
  }
</style>

<script>
  export default {
    name: "artisan",

    data()
    {
      return {
        defaultCommand:  'Select a command',
        selectedCommand: null,
        commands:        app.commands,
        running:         false,
        search:          null,
        results:         null,
        resultSuccess:   null,
        showCommands:    true,
      }
    },

    computed: {
      filteredCommands()
      {
        let commands = this.commands
        let search   = this.search

        if (search != null || search == '') {
          commands = _.filter(commands, (command) => {
            return command.name.search(new RegExp(search, 'i')) !== -1
          })
        }

        return commands
      },

      hasPassables()
      {
        return _.has(this.selectedCommand, 'passables')
      },

      searchButtonText()
      {
        return this.showCommands ? 'Hide' : 'Show'
      },

      resultClass()
      {
        if (this.resultSuccess === true) {
          return 'success'
        }

        if (this.resultSuccess === false) {
          return 'danger'
        }

        return null
      },
    },

    methods: {
      setUpCommand(command)
      {
        this.selectedCommand = command
        this.showCommands    = false
      },

      toggleCommands(value = null)
      {
        if (value !== null) {
          return this.showCommands = value
        }

        this.showCommands = !this.showCommands
      },

      commandClass(command)
      {
        let classes       = 'command'
        let activeClasses = []

        if (command === this.selectedCommand) {
          activeClasses = ['active']
        }

        return _.join(
                _.concat(classes, activeClasses),
                ' '
        )
      },

      toggleFlag(index)
      {
        let value = this.selectedCommand.passables[index].value

        this.selectedCommand.passables[index].value = !value
      },

      runCommand()
      {
        this.running       = true
        this.results       = null
        this.resultSuccess = null

        axios.post('/admin/artisan/run', {command: this.selectedCommand})
                .then((response) => {
                  this.results       = response.data
                  this.resultSuccess = true
                })
                .catch((error) => {
                  console.log('error')
                  if (error.response) {
                    // The request was made and the server responded with a status code
                    // that falls out of the range of 2xx
                    this.results = error.response.data
                  } else if (error.request) {
                    // The request was made but no response was received
                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                    // http.ClientRequest in node.js
                    this.results = error.request
                  } else {
                    // Something happened in setting up the request that triggered an Error
                    this.results = error.message
                  }
                  this.resultSuccess = false
                })
                .then(() => {
                  this.running = false
                })
      }
    }
  }
</script>
