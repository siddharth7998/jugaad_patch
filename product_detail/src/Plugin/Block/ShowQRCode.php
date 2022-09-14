<?php

namespace Drupal\product_detail\Plugin\Block;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'QRCode Block' Block.
 *
 * @Block(
 *   id = "show_qr_code",
 *   admin_label = @Translation("Show QR Code"),
 *   category = @Translation("Show QR Code"),
 * )
 */
class ShowQRCode extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $options = new QROptions(
      [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
      ]
    );
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      if($node->bundle() == 'product'){
        $qrcode = (new QRCode($options))->render($node->field_purchase_link->uri);
      }
    }
    return [
      '#theme' => 'qr_code',
      '#data' => $qrcode,
    ]; 
  }

  public function getCacheMaxAge() {
    return 0;
  }

}