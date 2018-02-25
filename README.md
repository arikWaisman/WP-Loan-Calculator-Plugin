# WordPress Loan Calculator Plugin

### Shortcode
`[loan_calculator]`

- you can load the shortcode with pre-filled data/settings into the calculator as follows `[loan_calculator title="Loan Calculator"" loan_amount=100,000 term_length="30 Years" interest=6%]`


### Composer
- Composer is used to autoload the plugins classes. If a new class is added make sure the file name starts with a captial and matches the class name

### loan calculator UI
- the UI is built using react and redux. the script bundle is enqueued whenever the shortcode is used
- to make changes to the react/redux app cd into the UI dir `cd loan-calculator-ui`,  run `npm install` to download dependencies and then ru `npm run build-dev` to transpile and bundle the files.
