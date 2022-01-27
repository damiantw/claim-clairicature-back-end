const { expect } = require("chai");
const { ethers } = require("hardhat");

let clairicatures;

const deploy = async () => {
    const Clairicatures = await ethers.getContractFactory("Clairicatures");
    clairicatures = await Clairicatures.deploy();
    await clairicatures.deployed();
};

describe("Clairicatures Contract", function () {
    beforeEach(async function () {
        await deploy();
    });

    it("Has a name and symbol", async function () {
        expect(await clairicatures.name()).to.equal("Clairicatures");
        expect(await clairicatures.symbol()).to.equal("CLAIR");
    });

    it("Mints NFTs given an unclaimed employee ID and secret", async function () {
        const [owner] = await ethers.getSigners();
        await (
            await clairicatures.mint(
                owner.address,
                9,
                "5fb0f9a1-7257-47be-b92a-d2de8cf4a6d6"
            )
        ).wait();
        expect(await clairicatures.totalSupply()).to.equal(1);
        expect(await clairicatures.balanceOf(owner.address)).to.equal(1);
        expect(await clairicatures.ownerOf(9)).to.equal(owner.address);
        expect(await clairicatures.tokenURI(9)).to.equal(
            "ipfs://QmNzpesUHYoVDTMyt6EqaNZRHz6KBcgT9131MiuEazTs5Q"
        );
    });

    it("Reverts mint given an invalid employee secret", async function () {
        const [owner] = await ethers.getSigners();
        await expect(
            clairicatures.mint(
                owner.address,
                9,
                "60e4f27a-2f52-4218-8c59-b2ebb74b95aa"
            )
        ).to.be.revertedWith("Invalid secret");
        expect(await clairicatures.totalSupply()).to.equal(0);
    });

    it("Reverts mint given an invalid employee ID", async function () {
        const [owner] = await ethers.getSigners();
        await expect(
            clairicatures.mint(
                owner.address,
                45,
                "60e4f27a-2f52-4218-8c59-b2ebb74b95aa"
            )
        ).to.be.revertedWith("Employee does not exist");
        expect(await clairicatures.totalSupply()).to.equal(0);
    });

    it("Reverts mint for employee that has already claimed", async function () {
        const [owner] = await ethers.getSigners();
        await (
            await clairicatures.mint(
                owner.address,
                9,
                "5fb0f9a1-7257-47be-b92a-d2de8cf4a6d6"
            )
        ).wait();
        await expect(
            clairicatures.mint(
                owner.address,
                9,
                "5fb0f9a1-7257-47be-b92a-d2de8cf4a6d6"
            )
        ).to.be.revertedWith("ERC721: token already minted");
    });

    it("Allows adding employees with a unique ID", async function () {
        (
            await clairicatures.addEmployee(
                45,
                "John Smith",
                "ipfs://beer",
                "0xf3fdc8934e96c3f2057cdfa6f5b620ba71d76813620f5d511cd65bfa164d1ec6"
            )
        ).wait();
        const johnSmith = await clairicatures.employees(45);
        expect(johnSmith.name).to.equal("John Smith");
        expect(johnSmith.tokenUri).to.equal("ipfs://beer");
        expect(johnSmith.secretHash).to.equal(
            "0xf3fdc8934e96c3f2057cdfa6f5b620ba71d76813620f5d511cd65bfa164d1ec6"
        );
        expect(johnSmith.exists).to.be.true;
    });

    it("Reverts add employee with non-unique ID", async function () {
        await expect(
            clairicatures.addEmployee(
                44,
                "John Smith",
                "ipfs://beer",
                "0xf3fdc8934e96c3f2057cdfa6f5b620ba71d76813620f5d511cd65bfa164d1ec6"
            )
        ).to.be.revertedWith("Employee ID already exists");
    });

    it("Allows contract owner to burn tokens and employees", async function () {
        const [owner] = await ethers.getSigners();
        await (
            await clairicatures.mint(
                owner.address,
                9,
                "5fb0f9a1-7257-47be-b92a-d2de8cf4a6d6"
            )
        ).wait();
        await (await clairicatures.burn(9)).wait();
        expect(await clairicatures.totalSupply()).to.equal(0);
        expect(await clairicatures.balanceOf(owner.address)).to.equal(0);
        await expect(clairicatures.ownerOf(9)).to.be.revertedWith(
            "ERC721: owner query for nonexistent token'"
        );
        const damian = await clairicatures.employees(9);
        expect(damian.exists).to.be.false;
    });

    it("Is pausable", async function () {
        const [owner, addr1] = await ethers.getSigners();
        expect(await clairicatures.paused()).to.be.false;
        await (await clairicatures.pause()).wait();
        expect(await clairicatures.paused()).to.be.true;
        await expect(
            clairicatures.mint(
                owner.address,
                9,
                "5fb0f9a1-7257-47be-b92a-d2de8cf4a6d6"
            )
        ).to.be.revertedWith("ERC721Pausable: token transfer while paused");
        await (await clairicatures.unpause()).wait();
        expect(await clairicatures.paused()).to.be.false;
        await clairicatures.mint(
            owner.address,
            9,
            "5fb0f9a1-7257-47be-b92a-d2de8cf4a6d6"
        );
        expect(await clairicatures.ownerOf(9)).to.equal(owner.address);
        await (await clairicatures.pause()).wait();
        expect(await clairicatures.paused()).to.be.true;
        await expect(
            clairicatures.transferFrom(owner.address, addr1.address, 9)
        ).to.be.revertedWith("ERC721Pausable: token transfer while paused");
        await (await clairicatures.unpause()).wait();
        await (
            await clairicatures.transferFrom(owner.address, addr1.address, 9)
        ).wait();
        expect(await clairicatures.ownerOf(9)).to.equal(addr1.address);
    });

    it("Has functions only callable by owner", async function () {
        const [owner, addr1] = await ethers.getSigners();
        expect(await clairicatures.owner()).to.equal(owner.address);
        await expect(
            clairicatures.connect(addr1).renounceOwnership()
        ).to.be.revertedWith("Ownable: caller is not the owner");
        await expect(
            clairicatures.connect(addr1).transferOwnership(addr1.address)
        ).to.be.revertedWith("Ownable: caller is not the owner");
        await expect(
            clairicatures
                .connect(addr1)
                .addEmployee(
                    45,
                    "John Smith",
                    "ipfs://beer",
                    "0xf3fdc8934e96c3f2057cdfa6f5b620ba71d76813620f5d511cd65bfa164d1ec6"
                )
        ).to.be.revertedWith("Ownable: caller is not the owner");
        await expect(clairicatures.connect(addr1).burn(9)).to.be.revertedWith(
            "Ownable: caller is not the owner"
        );
    });

    it("Supports interfaces", async function () {
        expect(await clairicatures.supportsInterface(0x01ffc9a7)).to.be.true; // IERC165
        expect(await clairicatures.supportsInterface(0x80ac58cd)).to.be.true; // IERC721
        expect(await clairicatures.supportsInterface(0x5b5e139f)).to.be.true; // IERC721Metadata
        expect(await clairicatures.supportsInterface(0x780e9d63)).to.be.true; // IERC721Enumerable
        expect(await clairicatures.supportsInterface(0xffffffff)).to.be.false;
    });
});
