const ethers = require("ethers");

module.exports = ethers.Wallet.fromEncryptedJsonSync(
    process.env.WALLET_ENCRYPTED_JSON,
    process.env.WALLET_PASSWORD
);
