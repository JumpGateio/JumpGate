export default function (arr, limit) {
    if (!Array.isArray(arr)) {
        return false;
    }

    return arr.slice(0, limit);
}
