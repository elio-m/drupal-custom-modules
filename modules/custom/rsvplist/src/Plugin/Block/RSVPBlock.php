<?php
/**
 * @file
 * contains \Drupal\rsvplist\Plugin\Block\RSVPBlock
 */
namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides an 'RSVP' list block
 * @block(
 *  id = "rsvp_block",
 *  admin_lael = @Translation("RSVP Block"),
 * )
 */

class RSVPBlock extends BlockBase{
    
    public function build()
    {
        return \Drupal::formBuilder()->getForm('Drupal\rsvplist\Form\RSVPForm');
    } 

    public function blockAccess(AccountInterface $account)
    {
        
        $node = \Drupal::routeMatch()->getParameter('node');
        $nid = $node->nid->value;
        /**
         * @var \Drupal\rsvplist\EnablerService $enabler
         */
        $enabler = \Drupal::service('rsvplist.enabler');

        if(is_numeric($nid))
        {
            if($enabler->isEnabled($node)){
                return AccessResult::allowedIfHasPermission($account, 'view rsvplist');
            }
        }
        return AccessResult::forbidden();
    }
}