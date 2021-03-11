import Layout from '../Shared/Layout'

export const inertiaHelpers = {
  methods: {
    setLayout(title)
    {
      return (h, page) => h(Layout, {props: {title: title}}, [page])
    }
  }
}
