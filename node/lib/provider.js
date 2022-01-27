const ethers = require("ethers");

module.exports = new ethers.providers.JsonRpcProvider({
    url: process.env.JSON_RPC_URL,
});
