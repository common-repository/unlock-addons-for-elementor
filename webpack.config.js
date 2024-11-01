const defaults = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
  ...defaults,
  externals: {
    react: 'React',
    'react-dom': 'ReactDOM',
  },
  output: {
    path: path.resolve(__dirname, 'assets/build')
  },
  module: {
    ...defaults.module,
    rules: [
      ...defaults.module.rules,
      {
        test: /\.css$/i,
        use: ["postcss-loader"],
      }
    ],
  },
};
// "style-loader",  css-loader