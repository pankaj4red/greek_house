<?php

namespace App\Services;

use App\Logging\Logger;
use App\Reports\CampaignAwaitingApprovalFollowUpReport;
use App\Reports\CampaignCollectingPaymentFollowUpReport;
use App\Reports\CampaignDeadlineFollowUpReport;
use App\Reports\CampaignFulfillmentReport;
use App\Reports\CampaignNoOrdersFollowUpReport;
use Illuminate\Mail\Message;

class MailService
{
    public function signup($userId)
    {
        try {
            $user = user_repository()->find($userId);

            // Customer
            \Mail::send('emails.signup', [
                'user' => $user,
            ], function (Message $message) use ($user) {
                $message->subject(config('notifications.mail.prefix').'Greek House - Sign Up');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($user->email), $user->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function newCampaign($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);
            // Designer Group
            \Mail::send('emails.new_campaign', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Greek House - New Campaign: '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from_new_campaign.email'), config('notifications.mail.from_new_campaign.name'));
                $message->to(config('notifications.mail.design_new.email'), config('notifications.mail.design_new.name'));
            });
            // Support
            \Mail::send('emails.new_campaign', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from(config('notifications.mail.from_new_campaign.email'), config('notifications.mail.from_new_campaign.name'));
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function campaignClosed($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Customer
            \Mail::send('emails.campaign_closed', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Greek House - Payment closed on '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function designUploaded($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Customer
            \Mail::send('emails.design_uploaded', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Greek House - Design Uploaded: '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
            });

            // BCC
            \Mail::send('emails.design_uploaded', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function designApproved($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $files = [];
            foreach ($campaign->artwork_request->proofs as $proof) {
                $files[$proof->file->name] = $proof->file->getContent()->content;
            }

            // Designer
            $designerEmail = config('notifications.mail.support.email');
            $designerName = config('notifications.mail.support.name');
            if ($campaign->artwork_request->designer_id) {
                $designerEmail = get_email($campaign->artwork_request->designer->email);
                $designerName = $campaign->artwork_request->designer->getFullName();
            }
            \Mail::send('emails.design_approved_designer', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign, $files, $designerEmail, $designerName) {
                $message->subject(config('notifications.mail.prefix').'Design Approved - Campaign '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to($designerEmail, $designerName);
                foreach ($files as $name => $data) {
                    $message->attachData($data, $name);
                }
            });

            // Support
            \Mail::send('emails.design_approved_support', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign, $files) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                foreach ($files as $name => $data) {
                    $message->attachData($data, $name);
                }
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function deliverEarlier($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Support
            \Mail::send('emails.campaign_early_required', [
                'campaign'   => $campaign,
                'emailType' => 'urgent',
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')).' - URGENT Delivery');
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.contacts.support.email'), config('notifications.contacts.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function deliveryDateHelp($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Support
            \Mail::send('emails.campaign_early_required', [
                'campaign'   => $campaign,
                'emailType' => 'help',
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')).' - Delivery Date Help');
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.contacts.support.email'), config('notifications.contacts.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function campaignCloses24($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Customer
            \Mail::send('emails.campaign_closes_24_customer', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Campaign '.$campaign->id.' - Payment Closes in 24 Hours');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
            });

            // Designer
            if ($campaign->artwork_request->designer) {
                \Mail::send('emails.campaign_closes_24_designer', [
                    'campaign' => $campaign,
                ], function (Message $message) use ($campaign) {
                    $message->subject(config('notifications.mail.prefix').'Campaign '.$campaign->id.' - Payment Closes in 24 Hours');
                    $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                    $message->to(get_email($campaign->artwork_request->designer->email), $campaign->artwork_request->designer->getFullName());
                });
            }

            // Support
            \Mail::send('emails.campaign_closes_24_customer', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function quotePosted($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Customer
            if ($campaign->user) {
                \Mail::send('emails.quote_posted', [
                    'campaign' => $campaign,
                ], function (Message $message) use ($campaign) {
                    $message->subject(config('notifications.mail.prefix').'Greek House - Quote Posted: '.$campaign->id.' - '.$campaign->name);
                    $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                    $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
                });
            }

            // BCC
            \Mail::send('emails.quote_posted', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function orderReceipt($orderId)
    {
        try {
            $order = order_repository()->find($orderId);
            $email = $order->contact_email;
            $name = $order->contact_first_name.' '.$order->contact_last_name;

            // Customer
            \Mail::send('emails.order_receipt', [
                'order' => $order,
            ], function (Message $message) use ($email, $name) {
                $message->subject(config('notifications.mail.prefix').'Thanks for placing your order with Greek House!');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($email), $name);
            });

            // BCC
            \Mail::send('emails.order_receipt', [
                'order' => $order,
            ], function (Message $message) use ($email, $name, $order) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$order->campaign->id, $order->campaign->name], config('notifications.mail.support.subject')));
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function orderShipped($orderId)
    {
        try {
            $order = order_repository()->find($orderId);

            // Customer
            \Mail::send('emails.order_shipped', [
                'user'  => getFullName($order->contact_first_name, $order->contact_last_name),
                'order' => $order,
            ], function (Message $message) use ($order) {
                $message->subject(config('notifications.mail.prefix').'Greek House - Order Shipped');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to($order->contact_email, getFullName($order->contact_first_name, $order->contact_last_name));
            });

            // BCC
            \Mail::send('emails.order_shipped', [
                'user'  => getFullName($order->contact_first_name, $order->contact_last_name),
                'order' => $order,
            ], function (Message $message) use ($order) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$order->campaign->id, $order->campaign->name], config('notifications.mail.support.subject')));
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function campaignFulfillment($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $sizes = [];
            $total = 0;
            $hasIndividual = false;
            foreach ($campaign->product_colors->first()->product->sizes as $size) {
                $sizes[$size->size->short] = 0;
            }
            foreach ($campaign->success_orders as $campaignOrder) {
                if ($campaignOrder->shipping_type == 'individual') {
                    $hasIndividual = true;
                }
                foreach ($campaignOrder->entries as $entry) {
                    if (! isset($sizes[$entry->size->short])) {
                        $sizes[$entry->size->short] = 0;
                    }
                    $sizes[$entry->size->short] += $entry->quantity;
                    $total += $entry->quantity;
                }
            }

            $files = [];
            $campaignFulfillmentReport = \App::make(CampaignFulfillmentReport::class);
            $campaignFulfillmentReport->put('campaign_id', $campaign->id);
            $files['CSV '.date('M-d-Y H:i:s').'.csv'] = $campaignFulfillmentReport->csv();

            // Support + Fulfillment
            \Mail::send('emails.campaign_fulfillment', [
                'campaign'      => $campaign,
                'sizes'         => $sizes,
                'hasIndividual' => $hasIndividual,
                'total'         => $total,
            ], function (Message $message) use ($campaign, $files) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.mail.fulfillment.email'), config('notifications.mail.name'));
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                foreach ($files as $name => $data) {
                    $message->attachData($data, $name);
                }
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function messagePosted($campaignId, $userId, $messageText, $fileId = null)
    {
        try {
            $user = user_repository()->find($userId);
            $campaign = campaign_repository()->find($campaignId);

            $usersToNotify = [];
            if ($campaign->user_id && $campaign->user_id != $userId) {
                $usersToNotify[] = $campaign->user;
            }
            if ($campaign->artwork_request->designer_id && $campaign->artwork_request->designer_id != $userId) {
                $usersToNotify[] = $campaign->artwork_request->designer;
            }
            $files = [];
            if ($fileId != null) {
                $file = file_repository()->find($fileId);
                $files[$file->name] = $file->getContent()->content;
            }

            // Customer + Designer + Manager
            foreach ($usersToNotify as $notify) {
                \Mail::send('emails.message_posted', [
                    'user'        => $user,
                    'notify'      => $notify,
                    'campaign'    => $campaign,
                    'messageText' => $messageText,
                ], function (Message $message) use ($notify, $user, $campaign, $files) {
                    $message->subject(config('notifications.mail.prefix').'A message was posted to Campaign '.$campaign->id.' - '.$campaign->name);
                    $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                    $message->to(get_email($notify->email), $notify->getFullName());
                    foreach ($files as $name => $data) {
                        $message->attachData($data, $name);
                    }
                });
            }

            // Support
            if ($campaign->user_id && $campaign->user_id == $userId || $campaign->user->account_manager_id && $campaign->user->account_manager_id == $userId) {
                if ($user && $user->isType(['admin', 'support'])) {
                    return;
                }
                $notify = (object) ['first_name' => 'Support'];
                \Mail::send('emails.message_posted', [
                    'user'        => $user,
                    'notify'      => $notify,
                    'campaign'    => $campaign,
                    'messageText' => $messageText,
                ], function (Message $message) use ($notify, $user, $campaign, $files) {
                    $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                    $message->from($user->email, $user->getFullName());
                    $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                    $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                    foreach ($files as $name => $data) {
                        $message->attachData($data, $name);
                    }
                });
            }
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function revisionRequested($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Designer
            $designerEmail = config('notifications.mail.support.email');
            $designerName = config('notifications.mail.support.name');
            if ($campaign->artwork_request->designer_id) {
                $designerEmail = get_email($campaign->artwork_request->designer->email);
                $designerName = $campaign->artwork_request->designer->getFullName();
            }
            \Mail::send('emails.revision_requested', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign, $designerEmail, $designerName) {
                $message->subject(config('notifications.mail.prefix').'Revision Requested for '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to($designerEmail, $designerName);
            });

            // Support
            \Mail::send('emails.revision_requested', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function campaignQuantityNotMet($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Customer
            \Mail::send('emails.campaign_quantity_not_met', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Campaign Quantity not Met '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
            });

            // BCC
            \Mail::send('emails.campaign_quantity_not_met', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function campaignQuantityNotMetSupport($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $total = 0;
            foreach ($campaign->success_orders as $order) {
                $total += $order->quantity;
            }

            // Support
            \Mail::send('emails.campaign_quantity_not_met_support', [
                'campaign' => $campaign,
                'total'    => $total,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from($campaign->user->email, $campaign->user->getFullName());
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function campusManagerApp($data)
    {
        try {
            // Customer
            \Mail::send('emails.campus_manager_app', [
                'data' => $data,
            ], function (Message $message) use ($data) {
                $message->subject(config('notifications.mail.prefix').'Greek House - Campus Manager App');
                $message->from(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->to(config('notifications.mail.jobs.email'), config('notifications.mail.job.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function campusManagerApproveRequired($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            if ($campaign->user->account_manager_id) {
                \Mail::send('emails.campus_manager_approval_required', [
                    'campaign' => $campaign,
                ], function (Message $message) use ($campaign) {
                    $message->subject(config('notifications.mail.prefix').'Campaign '.$campaign->id.' - Need CM Approval');
                    $message->from(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                    $message->to(get_email($campaign->user->account_manager->email), $campaign->user->account_manager->getFullName());
                    $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                });
            }
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function artworkBad($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Support
            \Mail::send('emails.fulfillment_artwork_bad_support', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function garmentBad($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Support
            \Mail::send('emails.fulfillment_garment_bad_support', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                $message->from(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function fulfillmentMarkShipped($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Decorator
            \Mail::send('emails.fulfillment_mark_shipped_printer', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Campaign not yet marked as shipped '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function fulfillmentPrintDateReset($campaignId, $oldDate)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Decorator
            \Mail::send('emails.fulfillment_print_date_reset', [
                'campaign' => $campaign,
                'oldDate'  => $oldDate,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Campaign '.$campaign->id.' - Updated Print Date');
                $message->from(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function fulfillmentMessage($campaignId, $senderId, $messageText)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $user = user_repository()->find($senderId);

            if ($user->isType(['support', 'admin'])) {
                // Decorator
                \Mail::send('emails.fulfillment_message_posted_printer', [
                    'campaign'    => $campaign,
                    'sender'      => $user,
                    'messageText' => $messageText,
                ], function (Message $message) use ($campaign) {
                    $message->subject(config('notifications.mail.prefix').'A fulfilment message has been posted - '.$campaign->id.' - '.$campaign->name);
                    $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                    $message->to(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
                });
            } else {
                // Support
                \Mail::send('emails.fulfillment_message_posted_support', [
                    'campaign'    => $campaign,
                    'sender'      => $user,
                    'messageText' => $messageText,
                ], function (Message $message) use ($campaign) {
                    $message->subject(config('notifications.mail.prefix').str_replace(['%id', '%name'], [$campaign->id, $campaign->name], config('notifications.mail.support.subject')));
                    $message->from(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
                    $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                    $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                });
            }
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function newArtworkUpdate($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Decorator
            \Mail::send('emails.fulfillment_new_artwork_update_printer', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'The artwork has been updated - '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function newGarmentUpdate($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Decorator
            \Mail::send('emails.fulfillment_new_garment_update_printer', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'The garment has been updated - '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function fulfillmentSubmitted($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Decorator
            \Mail::send('emails.fulfillment_submitted_printer', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'A campaign was been submitted - '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function fulfillmentUpdated($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Decorator
            \Mail::send('emails.fulfillment_update_printer', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'A campaign was updated - '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendErrorAlert($record)
    {
        try {
            \Mail::send('emails.error_alert', [
                'record' => $record,
            ], function (Message $message) use ($record) {
                $message->subject(config('notifications.mail.prefix').'[Exception Alert] '.$record['message'].' ['.uniqid().']');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(config('notifications.mail.error.email'), config('notifications.mail.error.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendLogReport($logs)
    {
        try {
            \Mail::send('emails.log_report', [
                'logs' => $logs,
            ], function (Message $message) {
                $message->subject(config('notifications.mail.prefix').' Daily Log Report '.date('j F Y'));
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $emails = explode(',', config('notifications.mail.log_report.email'));
                foreach ($emails as $email) {
                    $message->to($email, config('notifications.mail.error.name'));
                }
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendAwaitingApprovalReminder($campaignId, $overrideNow = null)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $daysSinceAwaitingApproval = $campaign->getDaysSince($campaign->getStateDate('awaiting_approval'), $overrideNow);

            \Mail::send('emails.reminder_awaiting_approval', [
                'campaign'                  => $campaign,
                'daysSinceAwaitingApproval' => $daysSinceAwaitingApproval,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Your Design Is Ready');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendAwaitingApprovalFinalReminder($campaignId, $overrideNow = null)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $daysSinceAwaitingApproval = $campaign->getDaysSince($campaign->getStateDate('awaiting_approval'), $overrideNow);

            \Mail::send('emails.reminder_awaiting_approval_final', [
                'campaign'                  => $campaign,
                'daysSinceAwaitingApproval' => $daysSinceAwaitingApproval,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Final Reminder - Your Design Is Ready');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });

            if ($campaign->user->account_manager_id) {
                \Mail::send('emails.reminder_awaiting_approval_final', [
                    'campaign'                  => $campaign,
                    'daysSinceAwaitingApproval' => $daysSinceAwaitingApproval,
                ], function (Message $message) use ($campaign) {
                    $message->subject(config('notifications.mail.prefix').'Final Reminder - Your Design Is Ready');
                    $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                    $message->to(get_email($campaign->user->account_manager->email), $campaign->user->account_manager->getFullName());
                    $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                });
            }
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendCollectingPaymentReminder($campaignId, $overrideNow = null)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $today = $overrideNow ? $overrideNow : date('Y-m-d');
            $daysUntilPaymentClose = floor((strtotime($campaign->close_date) - strtotime($today)) / (24 * 60 * 60));
            if ($daysUntilPaymentClose == 0) {
                // Avoid negative zero
                $daysUntilPaymentClose = 0;
            }

            \Mail::send('emails.reminder_collecting_payment', [
                'campaign'              => $campaign,
                'daysUntilPaymentClose' => $daysUntilPaymentClose,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Collecting Payment Reminder');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendCollectingPaymentFinalReminder($campaignId, $overrideNow = null)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $today = $overrideNow ? $overrideNow : date('Y-m-d');
            $daysUntilPaymentClose = floor((strtotime($campaign->close_date) - strtotime($today)) / (24 * 60 * 60));
            if ($daysUntilPaymentClose == 0) {
                // Avoid negative zero
                $daysUntilPaymentClose = 0;
            }

            \Mail::send('emails.reminder_collecting_payment_final', [
                'campaign'              => $campaign,
                'daysUntilPaymentClose' => $daysUntilPaymentClose,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Final Reminder - Your Order Closing for Payment');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });

            if ($campaign->user->account_manager_id) {
                \Mail::send('emails.reminder_collecting_payment_final', [
                    'campaign'              => $campaign,
                    'daysUntilPaymentClose' => $daysUntilPaymentClose,
                ], function (Message $message) use ($campaign) {
                    $message->subject(config('notifications.mail.prefix').'Final Reminder - Your Order Closing for Payment');
                    $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                    $message->to(get_email($campaign->user->account_manager->email), $campaign->user->account_manager->getFullName());
                });
            }
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendDeadlineReminder($campaignId, $overrideNow = null)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $daysUntilPaymentClose = $campaign->getPaymentDeadlineDaysLeft($overrideNow);

            \Mail::send('emails.reminder_deadline', [
                'campaign'              => $campaign,
                'daysUntilPaymentClose' => $daysUntilPaymentClose,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Order Deadline Approaching');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendDeadlineFinalReminder($campaignId, $overrideNow = null)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            $daysUntilPaymentClose = $campaign->getPaymentDeadlineDaysLeft($overrideNow);

            \Mail::send('emails.reminder_deadline_final', [
                'campaign'              => $campaign,
                'daysUntilPaymentClose' => $daysUntilPaymentClose,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Final Reminder - Action Needed');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });

            if ($campaign->user->account_manager_id) {
                \Mail::send('emails.reminder_deadline_final', [
                    'campaign'              => $campaign,
                    'daysUntilPaymentClose' => $daysUntilPaymentClose,
                ], function (Message $message) use ($campaign) {
                    $message->subject(config('notifications.mail.prefix').'Final Reminder - Action Needed');
                    $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                    $message->to(get_email($campaign->user->account_manager->email), $campaign->user->account_manager->getFullName());
                });
            }
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendDeadlineReminderFollowUp()
    {
        try {
            $files = [];
            $report = \App::make(CampaignDeadlineFollowUpReport::class);
            $files['CSV '.date('M-d-Y H:i:s').'.csv'] = $report->csv();

            \Mail::send('emails.follow_up_deadline', [], function (Message $message) use ($files) {
                $message->subject(date('m/d/Y').' - Deadline Past');
                $message->from(config('notifications.mail.reports.email'), config('notifications.mail.reports.name'));
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                foreach ($files as $name => $data) {
                    $message->attachData($data, $name);
                }
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendCollectingPaymentFollowUp()
    {
        try {
            $files = [];
            $report = \App::make(CampaignCollectingPaymentFollowUpReport::class);
            $files['Payment'.date('M-d-Y H:i:s').'.csv'] = $report->csv();

            \Mail::send('emails.follow_up_collecting_payment', [], function (Message $message) use ($files) {
                $message->subject(date('m/d/Y').' - Collecting Payment Reports');
                $message->from(config('notifications.mail.reports.email'), config('notifications.mail.reports.name'));
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                foreach ($files as $name => $data) {
                    $message->attachData($data, $name);
                }
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendAwaitingApprovalFollowUp()
    {
        try {
            $files = [];
            $report = \App::make(CampaignAwaitingApprovalFollowUpReport::class);
            $files['Approvals '.date('M-d-Y H:i:s').'.csv'] = $report->csv();

            \Mail::send('emails.follow_up_awaiting_approval', [], function (Message $message) use ($files) {
                $message->subject(date('m/d/Y').' - Awaiting Approval Final Reminders');
                $message->from(config('notifications.mail.reports.email'), config('notifications.mail.reports.name'));
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                foreach ($files as $name => $data) {
                    $message->attachData($data, $name);
                }
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function sendNoOrdersFollowUp()
    {
        try {
            $files = [];
            $report = \App::make(CampaignNoOrdersFollowUpReport::class);
            $files['NoOrders '.date('M-d-Y H:i:s').'.csv'] = $report->csv();
            \Mail::send('emails.follow_up_no_orders', [], function (Message $message) use ($files) {
                $message->subject(date('m/d/Y').' - No Orders Reports');
                $message->from(config('notifications.mail.reports.email'), config('notifications.mail.reports.name'));
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
                foreach ($files as $name => $data) {
                    $message->attachData($data, $name);
                }
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function newCustomer($userId)
    {
        try {
            $user = user_repository()->find($userId);

            // Support
            \Mail::send('emails.new_customer', [
                'user' => $user,
            ], function (Message $message) use ($user) {
                $message->subject(config('notifications.mail.prefix').'New Customer');
                $message->from(config('notifications.mail.from_new_campaign.email'), config('notifications.mail.from_new_campaign.name'));
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function fulfillmentIssueReported($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            // Support
            \Mail::send('emails.fulfillment_issue_reported', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'A fulfillment issue has been reported - '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function fulfillmentIssueSolved($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            if (! $campaign->decorator) {
                return;
            }

            // Decorator
            \Mail::send('emails.fulfillment_issue_solved', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'A fulfillment issue has been marked as solved - '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function fulfillmentPrintingDateUpdated($campaignId, $oldPrintingDate = null)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            if (! $campaign->decorator) {
                return;
            }

            // Support
            \Mail::send('emails.fulfillment_printing_date_updated_support', [
                'campaign'        => $campaign,
                'oldPrintingDate' => $oldPrintingDate,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Campaign '.$campaign->id.' - Print Date Change');
                if ($campaign->decorator) {
                    $message->from(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
                } else {
                    $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                }
                $message->to(config('notifications.mail.support.email'), config('notifications.mail.support.name'));
            });

            if (! $campaign->decorator) {
                return;
            }

            // Decorator
            \Mail::send('emails.fulfillment_printing_date_updated', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'The printing date has been updated - '.$campaign->id.' - '.$campaign->name);
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->decorator->email), $campaign->decorator->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function workWithUs($data)
    {
        try {
            \Mail::send('emails.work_with_us', [
                'data' => $data,
            ], function (Message $message) use ($data) {
                $message->subject(config('notifications.mail.prefix').'Greek House - Work with Us');
                $message->from(config('notifications.mail.from_new_campaign.email'), config('notifications.mail.from_new_campaign.name'));
                $message->to('hiring@greekhouse.org');
                $message->bcc(config('notifications.mail.bcc.email'), config('notifications.mail.bcc.name'));
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }

    public function onHold($campaignId)
    {
        try {
            $campaign = campaign_repository()->find($campaignId);

            if (! $campaign->user) {
                return;
            }

            // User
            \Mail::send('emails.on_hold', [
                'campaign' => $campaign,
            ], function (Message $message) use ($campaign) {
                $message->subject(config('notifications.mail.prefix').'Your campaign is currently being reviewed');
                $message->from(config('notifications.mail.from.email'), config('notifications.mail.from.name'));
                $message->to(get_email($campaign->user->email), $campaign->user->getFullName());
            });
        } catch (\Exception $ex) {
            Logger::logFallback($ex);
        }
    }
}
