import { ComputeBudgetProgram, Connection, Keypair, PublicKey, SystemProgram, Transaction, clusterApiUrl, sendAndConfirmTransaction } from "@solana/web3.js";
import { Metaplex, keypairIdentity, bundlrStorage, toMetaplexFile, toBigNumber } from "@metaplex-foundation/js";
import { getAssociatedTokenAddress, getAssociatedTokenAddressSync } from "@solana/spl-token";
import * as fs from 'fs';
import { AnchorProvider, BN, Idl, Program, Wallet, setProvider, web3 } from "@coral-xyz/anchor";
import dotenv from "dotenv";
import base58, * as bs58 from "bs58";
import idl from "../target/idl/nft.json";
import { set } from "@coral-xyz/anchor/dist/cjs/utils/features";
import { randomBytes } from "crypto";
dotenv.config(); 

const privateKey = bs58.decode(process.env.PRIVATE_KEY ?? '')
const payer = Keypair.fromSecretKey(privateKey);
const wallet = new Wallet(payer)

const privateKey0 = bs58.decode(process.env.PRIVATE_KEY0 ?? '')
const payer0 = Keypair.fromSecretKey(privateKey0);
const wallet0 = new Wallet(payer0)

const connection = new Connection(clusterApiUrl("devnet"), "confirmed");
const PROGRAM_ID = new PublicKey(process.env.MINT_NFT_PROGRAM ?? "");

  
async function mintNft() {    
  let provider: AnchorProvider = new AnchorProvider(connection, wallet, { commitment: "confirmed" })
  setProvider(provider)
  const program = new Program(idl as Idl, PROGRAM_ID)
  const actionNftTitle = "Action NFT";
  const actionNftSymbol = "ACTION";
  const actionNftUri = "https://raw.githubusercontent.com/Coding-and-Crypto/Solana-NFT-Marketplace/master/assets/example.json"; 

  const freeTicketNftTitle = "Free ticket NFT";
  const freeTicketNftSymbol = "FTICKET";
  const freeTicketNftUri = "https://raw.githubusercontent.com/Coding-and-Crypto/Solana-NFT-Marketplace/master/assets/example.json"; 

  const ticketNftTitle = "Ticket NFT";
  const ticketNftSymbol = "TICKET";
  const ticketNftUri = "https://raw.githubusercontent.com/Coding-and-Crypto/Solana-NFT-Marketplace/master/assets/example.json"; 
  const TOKEN_METADATA_PROGRAM_ID = new PublicKey(
    "metaqbxxUerdq28cj1RbAWkYQm3ybzjb6a8bt518x1s"
  );

  const payerMint = Keypair.fromSecretKey(Uint8Array.from([
    208,32,235,43,108,17,94,0,58,152,203,22,78,114,36,184,81,177,102,173,49,1,246,137,27,167,96,62,200,39,60,244,58,205,50,173,207,138,166,222,183,97,57,233,167,247,218,194,224,24,230,75,232,119,44,39,208,112,252,142,250,93,136,227
  ])); //TODO enter mint
  const mintKeypair = new Wallet(payerMint);
  console.log(`mint: ${mintKeypair.publicKey}`)

//   const tokenAddress = await getAssociatedTokenAddress(
//     mintKeypair.publicKey,
//     wallet.publicKey
//   );

  const buyTokenAddress = await getAssociatedTokenAddress(
    mintKeypair.publicKey,
    wallet0.publicKey
  );

  const seed = new BN("15608558783288954992"); // TODO: enter seed
  const pool = web3.PublicKey.findProgramAddressSync(
    [
      Buffer.from("state"),
      seed.toArrayLike(Buffer, "le", 8)
    ],
    program.programId
  )[0];

  const poolTokenAddress = await getAssociatedTokenAddressSync(
    mintKeypair.publicKey,
    pool,
    true
  );
  console.log(`poolTokenAddress: ${poolTokenAddress}`)


  const feeWallet = new PublicKey("9fXYPrfSfmenmPdyNW1AqaP5TSHMj5qkwwEuyQEa1ut2");

  // console.log(`metadata: ${metadataAddress}`)
  // console.log(`mintAuth: ${wallet.publicKey}`)
  // console.log(`ownerAuth: ${wallet0.publicKey}`)

  try{
    let tx = new Transaction();
    const setComputeUnitLimitInstruction = ComputeBudgetProgram.setComputeUnitLimit(
      { units: 400_000 }
    );
    // // action

    // const transferTx = await program.methods
    // .claim()
    // .accounts(
    //   {
    //     mint: mintKeypair.publicKey,
    //     ownerTokenAccount: tokenAddress,
    //     ownerAuthority: wallet.publicKey,
    //     buyerTokenAccount: buyTokenAddress,
    //     buyerAuthority: wallet0.publicKey,
    //   }
    // ).instruction();

    // // free ticket
    
    // const transferTx = await program.methods
    // .claim()
    // .accounts(
    //   {
    //     mint: mintAddr.publicKey,
    //     ownerTokenAccount: tokenAddress,
    //     ownerAuthority: owner,
    //     buyerTokenAccount: buyTokenAddress,
    //     buyerAuthority: wallet0.publicKey,
    //   }
    // ).instruction();

    // ticket
    const transferTx = await program.methods
    .claim()
    .accounts(
      {
        mint: mintKeypair.publicKey,
        poolTokenAccount: poolTokenAddress,
        pool: pool,
        buyerTokenAccount: buyTokenAddress,
        buyerAuthority: wallet0.publicKey,
        feeWallet: wallet.publicKey,
      }
    ).instruction();
    tx.add(setComputeUnitLimitInstruction, transferTx);
    const createTx = await sendAndConfirmTransaction(
      connection,
      tx,
      [payer0, payerMint]
    );
    console.log(tx)

  }catch (err) {
    console.log("Transaction error: ", err);
  }
  
}

function generateExplorerTxUrl(txId: string) {
  return `https://explorer.solana.com/tx/${txId}?cluster=devnet`;
}

async function main() {
  await mintNft();
}

main()