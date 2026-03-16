<?php
/**
 * ConciseUnderscoredVariableNameSniff.
 *
 * Ensures variable names use underscore format and are not too long.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Eric VILLARD <dev@eviweb.fr>
 * @copyright 2012 Eric VILLARD <dev@eviweb.fr>
 * @license   http://opensource.org/licenses/MIT MIT License
 */

namespace FuelPHP\Sniffs\NamingConventions;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ConciseUnderscoredVariableNameSniff implements Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array(
        'PHP',
        'JS',
        'CSS',
    );

    /**
     * Variable name length limit.
     *
     * @var int
     */
    public $maxlength = 30;

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_VAR, T_VARIABLE);
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

        // Make sure this is a variable.
        if ($tokens[$stackPtr]['type'] !== 'T_VARIABLE'
            && $tokens[$stackPtr]['type'] !== 'T_VARIABLE'
        ) {
            return;
        }

        $name = $tokens[$stackPtr]['content'];

        if (UnderscoredWithScopeFunctionNameSniff::isUnderscoreName($name) === false) {
            $error = 'Variable name "%s" does not use underscore format. ' .
                'Upper case forbidden.';
            $phpcsFile->addError($error, $stackPtr, 'NotUnderscore', array($name));
        }

        if (strlen($name) > $this->maxlength) {
            $warning = 'Variable name "%s" should be more concise. ' .
                'Actually more than ' . $this->maxlength . ' chars.';
            $phpcsFile->addWarning($warning, $stackPtr, 'VariableNameTooLong', array($name));
        }
    }
}
