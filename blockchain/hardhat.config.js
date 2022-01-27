require("@nomiclabs/hardhat-waffle");
require("@nomiclabs/hardhat-etherscan");
require('hardhat-abi-exporter');
const fs = require('fs');

const privateKey = fs.readFileSync('.secret').toString().trim();

/**
 * @type import('hardhat/config').HardhatUserConfig
 */
module.exports = {
    networks: {
        hardhat: {
            gas: 'auto',
        },
        mumbai: {
            url: 'https://rpc-mumbai.maticvigil.com/',
            chainId: 80001,
            gas: 'auto',
            accounts: [privateKey],
        },
        polygon: {
            url: 'https://polygon-rpc.com/',
            chainId: 137,
            gas: 'auto',
            accounts: [privateKey],
        },
    },
    solidity: {
        version: "0.8.9",
        settings: {
            optimizer: {
                enabled: true,
                runs: 200,
            }
        }
    },
    abiExporter: {
        runOnCompile: true,
        clear: true,
        flat: true,
        pretty: true,
    },
    etherscan: {
        apiKey: {
            polygon: process.env.POLYSCAN_API_KEY,
            polygonMumbai: process.env.POLYSCAN_API_KEY,
        },
    }
};
