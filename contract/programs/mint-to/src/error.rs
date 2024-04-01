use anchor_lang::prelude::error_code;

#[error_code]
/// Errors relevant to this program's malfunction.
pub enum ErrorFactory {
    #[msg("MisMatchdFeeWalletAddress")]
    /// The fee wallet is not the mint authority
    MisMatchdFeeWalletAddress,
}