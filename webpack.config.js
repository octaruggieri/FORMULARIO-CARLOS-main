import path from 'path';

module.exports = {
    entry: "./src/index.js", // el archivo de entrada de tu proyecto
    output: {
        path: path.resolve(__dirname, "dist"), // la carpeta donde se guardará el archivo de salida
        filename: "bundle.js", // el nombre del archivo de salida
    },
    module: {
        rules: [
            {
                test: /\.js$/, // los archivos que terminan en .js serán procesados por Babel
                exclude: /node_modules/, // se excluyen los archivos de la carpeta node_modules
                use: {
                    loader: "babel-loader", // se usa el complemento de Babel para Webpack
                },
            },
        ],
    },
};
