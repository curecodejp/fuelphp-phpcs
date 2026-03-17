<?php
/**
 * IncrementDecrementSpacingSniff.
 *
 * Check that no space are used between variable and ++ or --.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Eric VILLARD <dev@eviweb.fr>
 * @copyright 2012 Eric VILLARD <dev@eviweb.fr>
 * @license   http://opensource.org/licenses/MIT MIT License
 */

namespace FuelPHP\Sniffs\WhiteSpace;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class IncrementDecrementSpacingSniff implements Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
        'PHP',
        'JS',
    );

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_INC,
            T_DEC,
            T_VARIABLE,
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param File $phpcsFile All the tokens found in the document.
     * @param int  $stackPtr  The position of the current token in
     *                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['code'] === T_INC
            || $tokens[$stackPtr]['code'] === T_DEC
        ) {
            if ($tokens[$stackPtr - 1]['code'] !== T_VARIABLE
                && $tokens[$stackPtr + 1]['code'] !== T_VARIABLE
            ) {
                $error = 'Increment and decrement operators need to be close to ' .
                    'their variable. No inside space is allowed.';
                $phpcsFile->addError($error, $stackPtr, 'NoInsideSpaceAllowed');
            }
        }
    }
}
