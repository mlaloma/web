/**
 * Internal dependencies
 */
import { RichText } from "@wordpress/block-editor";
const { EBDisplayIcon, sanitizeURL, BlockProps } = window.EBControls;

const save = ({ attributes }) => {
    const {
        blockId,
        buttonText,
        iconPosition,
        addIcon,
        icon,
        buttonURL,
        newWindow,
        addNofollow,
        hoverEffect,
        classHook,
    } = attributes;

    return (
        <BlockProps.Save
            attributes={attributes}
        >
            <div
                className={`eb-parent-wrapper eb-parent-${blockId} ${classHook}`}
            >
                <div
                    className={`eb-button-wrapper eb-button-alignment ${blockId}`}
                >
                    <div className="eb-button">
                        <a
                            className={`eb-button-anchor${hoverEffect ? ` ${hoverEffect}` : ""
                                }`}
                            href={buttonURL ? sanitizeURL(buttonURL) : ""}
                            {...(newWindow && { target: "_blank" })}
                            rel={addNofollow ? "nofollow noopener" : "noopener"}
                        >
                            {addIcon && iconPosition === "left" ? (
                                <EBDisplayIcon icon={icon} className={"eb-button-icon eb-button-icon-left hvr-icon"} />
                            ) : (
                                ""
                            )}
                            <RichText.Content value={buttonText} />
                            {addIcon && iconPosition === "right" ? (
                                <EBDisplayIcon icon={icon} className={"eb-button-icon eb-button-icon-right hvr-icon"} />
                            ) : (
                                ""
                            )}
                        </a>
                    </div>
                </div>
            </div>
        </BlockProps.Save>
    );
};

export default save;
