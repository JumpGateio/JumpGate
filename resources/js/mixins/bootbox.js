export const bootbox = {
  methods: {
    bootbox(type, message)
    {
      let icon = null

      switch (type) {
        case 'danger':
          icon = 'fa fa-exclamation-triangle'
          break
        case 'info':
          icon = 'fa fa-info-circle'
          break
        case 'warning':
          icon = 'fa fa-info'
          break
        case 'success':
          icon = 'fa fa-check-circle'
          break
      }

      $.notify({message: message, icon: icon}, {type: type});
    }
  }
}
