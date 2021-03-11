export const helpers = {
  methods: {
    percent(num_amount, num_total)
    {
      if (num_amount == 0 || num_total == 0) {
        return 0
      }

      return Math.round((num_amount / num_total) * 100)
    },

    ratio(num_amount, num_total, fixed = 2)
    {
      if (num_amount == 0 || num_total == 0) {
        return 0
      }

      return (num_amount / num_total).toFixed(fixed)
    },

    number_format(number, decimals = 0, dec_point = '.', thousands_sep = ',')
    {
      // Strip all characters but numerical ones.
      number         = (number + '').replace(/[^0-9+\-Ee.]/g, '')
      var n          = !isFinite(+number) ? 0 : +number,
          prec       = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep        = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec        = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s          = '',
          toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec)
            return '' + Math.round(n * k) / k
          }
      // Fix for IE parseFloat(0.55).toFixed(0) = 0
      s              = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
      }
      if ((s[1] || '').length < prec) {
        s[1] = s[1] || ''
        s[1] += new Array(prec - s[1].length + 1).join('0')
      }
      return s.join(dec)
    },

    toRomanNumeral(num)
    {
      if (!+num) {
        return NaN
      }
      var digits = String(+num).split(""),
          key    = [
            "",
            "C",
            "CC",
            "CCC",
            "CD",
            "D",
            "DC",
            "DCC",
            "DCCC",
            "CM",
            "",
            "X",
            "XX",
            "XXX",
            "XL",
            "L",
            "LX",
            "LXX",
            "LXXX",
            "XC",
            "",
            "I",
            "II",
            "III",
            "IV",
            "V",
            "VI",
            "VII",
            "VIII",
            "IX"
          ],
          roman  = "",
          i      = 3
      while (i--) {
        roman = (key[+digits.pop() + (i * 10)] || "") + roman
      }
      return Array(+digits.join("") + 1).join("M") + roman
    },
  }
}
