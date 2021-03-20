export default function (arr, offset) {
    if (!Array.isArray(arr)) {
        return false;
    }

    return arr.slice(offset, arr.length)
}
