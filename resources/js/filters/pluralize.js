export default function (word, amount) {
    return amount === 1 ? word : _(word).pluralize(amount)
}
