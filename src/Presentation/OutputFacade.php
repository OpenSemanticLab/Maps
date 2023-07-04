<?php

declare( strict_types = 1 );

namespace Maps\Presentation;

use OutputPage;
use ParserOutput;

class OutputFacade {

	private ?OutputPage $outputPage = null;
	private ?ParserOutput $parserOutput = null;

	public static function newFromOutputPage( OutputPage $outputPage ) {
		$instance = new self();
		$instance->outputPage = $outputPage;
		return $instance;
	}

	public static function newFromParserOutput( ParserOutput $parserOutput ) {
		$instance = new self();
		$instance->parserOutput = $parserOutput;
		return $instance;
	}

	/*
	 * @param string $html
	 * @return string
	 */
	public function addHtml( string $html ) {
		if ( $this->outputPage !== null ) {
			$this->outputPage->addHTML( $html );
		}

		// @see: https://github.com/ProfessionalWiki/Maps/issues/734
		if ( $this->parserOutput !== null ) {
			$rawText = ( isset( $this->mText ) && $this->mText !== null ) ? $this->parserOutput->getRawText() : '';
			$this->parserOutput->setText( $rawText . $html );
		}
	}

	public function addModules( string ...$modules ) {
		if ( $this->outputPage !== null ) {
			$this->outputPage->addModules( $modules );
		}

		if ( $this->parserOutput !== null ) {
			$this->parserOutput->addModules( $modules );
		}
	}

	public function addHeadItem( string $name, string $html ) {
		if ( $this->outputPage !== null ) {
			$this->outputPage->addHeadItem( $name, $html );
		}

		if ( $this->parserOutput !== null ) {
			$this->parserOutput->addHeadItem( $html, $name );
		}
	}

}
