const hre = require("hardhat");
const ethers = hre.ethers;

async function main() {
    const Clairicatures = await ethers.getContractFactory("Clairicatures");
    const clairicatures = await Clairicatures.deploy();
    process.stdout.write(
        JSON.stringify({
            DEPLOYMENT_ADDRESS: clairicatures.address,
        })
    );
}

main()
    .then(() => process.exit(0))
    .catch((error) => {
        console.error(error);
        process.exit(1);
    });
